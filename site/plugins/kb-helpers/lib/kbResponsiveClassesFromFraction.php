<?php
declare(strict_types=1);

/**
 * Kirby fraction -> kb-grid class generator
 *
 * Supports fractions like: "1/12", "1/8", "1/6", "1/4", "1/3", "1/2", "2/3", "3/4"
 *
 * Output example: "col-1-12-lg col-1-6-md col-1-3-sm col-1-1-xs"
 */

/**
 * Breakpoint mapping:
 * For a given "start denominator" (12,8,6,4,3,2), define what denominator to use at each breakpoint.
 * This is exactly your matrix:
 *
 * lg: 12 8 6 4 3 2
 * md:  6 4 3 2 2 2
 * sm:  3 2 1 1 1 1
 * xs:  1 1 1 1 1 1
 */
const KB_GRID_BP_MAP = [
    'lg' => [12 => 12, 8 => 8, 6 => 6, 4 => 4, 3 => 3, 2 => 2],
    'md' => [12 =>  6, 8 => 4, 6 => 3, 4 => 2, 3 => 2, 2 => 2],
    'sm' => [12 =>  3, 8 => 2, 6 => 1, 4 => 1, 3 => 1, 2 => 1],
    'xs' => [12 =>  1, 8 => 1, 6 => 1, 4 => 1, 3 => 1, 2 => 1],
];

/**
 * Fractions you actually have SCSS utilities for.
 * (Keep in sync with your $fractions map in grid.scss)
 */
const KB_GRID_ALLOWED_FRACTIONS = [
    '1-1', '1-2', '1-3', '1-4', '1-6', '1-8', '1-12', '2-3', '3-4',
];

/**
 * Order of breakpoints to emit classes for.
 * Use ['lg','md','sm','xs'] if you want “from large downwards”.
 */
const KB_GRID_BP_ORDER = ['lg', 'md', 'sm', 'xs'];

/**
 * Convert a Kirby fraction string into responsive kb-grid classes.
 *
 * @param string $fraction  e.g. "1/12", "2/3", "3/4"
 * @param array  $bpMap     breakpoint denominator map (see KB_GRID_BP_MAP)
 * @param array  $bpOrder   order to output breakpoints (see KB_GRID_BP_ORDER)
 * @return string           e.g. "col-1-12-lg col-1-6-md col-1-3-sm col-1-1-xs"
 */
function kbResponsiveClassesFromFraction(
    string $fraction,
    array $bpMap = KB_GRID_BP_MAP,
    array $bpOrder = KB_GRID_BP_ORDER
): string {
    [$num, $den] = kbParseFraction($fraction);
    if ($num === null || $den === null) {
        // safe fallback
        return 'col-1-1';
    }

    // Figure out the "start denominator type" we will map from
    // (must be one of the keys used in your map, e.g. 12,8,6,4,3,2)
    $startDen = kbNearestSupportedStartDenominator($den, $bpMap);

    $classes = [];

    foreach ($bpOrder as $bp) {
        if (!isset($bpMap[$bp][$startDen])) {
            continue;
        }

        $targetDen = (int)$bpMap[$bp][$startDen];

        // Try to preserve the original ratio: num/den
        // We scale to the new denominator:
        // newNum = num * targetDen / den
        // Only valid if it becomes an integer AND <= targetDen.
        $newNum = ($num * $targetDen) / $den;

        if (is_int($newNum) || (is_float($newNum) && abs($newNum - round($newNum)) < 1e-9)) {
            $newNum = (int)round($newNum);
        } else {
            // can't represent exactly with this denominator -> fallback
            $newNum = null;
        }

        if ($newNum === null || $newNum < 1 || $newNum > $targetDen) {
            // Fallback strategy:
            // - if targetDen == 1 => full width (1/1)
            // - otherwise choose closest allowed fraction to the original ratio
            [$fallbackNum, $fallbackDen] = kbClosestAllowedFraction($num, $den);
            // But still apply breakpoint targetDen for the "grid system feel":
            // if targetDen is 1 -> force 1/1
            if ($targetDen === 1) {
                $newNum = 1;
                $targetDen = 1;
            } else {
                // attempt to scale the closest allowed fraction to targetDen as well
                $scaled = ($fallbackNum * $targetDen) / $fallbackDen;
                if (abs($scaled - round($scaled)) < 1e-9) {
                    $newNum = (int)round($scaled);
                } else {
                    // last resort: clamp to 1/targetDen (smallest) or full
                    $newNum = max(1, min($targetDen, (int)round(($num / $den) * $targetDen)));
                    if ($newNum < 1) $newNum = 1;
                }
            }
        }

        // Reduce fraction (e.g. 2/4 -> 1/2)
        [$rNum, $rDen] = kbReduceFraction($newNum, $targetDen);

        $key = "{$rNum}-{$rDen}";
        if (!in_array($key, KB_GRID_ALLOWED_FRACTIONS, true)) {
            // If reduced fraction isn't available in SCSS, try closest allowed.
            [$cNum, $cDen] = kbClosestAllowedFraction($rNum, $rDen);
            $rNum = $cNum;
            $rDen = $cDen;
        }

        $classes[] = "col-{$rNum}-{$rDen}-{$bp}";
    }

    // Dedupe while preserving order
    $classes = array_values(array_unique($classes));

    return $classes ? implode(' ', $classes) : 'col-1-1';
}

/**
 * Parses "2/3" => [2, 3]
 */
function kbParseFraction(string $fraction): array
{
    $fraction = trim($fraction);
    if ($fraction === '') return [null, null];

    $parts = explode('/', $fraction);
    if (count($parts) !== 2) return [null, null];

    $num = trim($parts[0]);
    $den = trim($parts[1]);

    if ($num === '' || $den === '') return [null, null];
    if (!is_numeric($num) || !is_numeric($den)) return [null, null];

    $num = (int)$num;
    $den = (int)$den;

    if ($den === 0 || $num === 0) return [null, null];

    // normalize sign (no negative widths)
    if ($num < 0 || $den < 0) return [null, null];

    return [$num, $den];
}

/**
 * Choose nearest supported start denominator from the map’s keys.
 */
function kbNearestSupportedStartDenominator(int $den, array $bpMap): int
{
    // take denominators from first breakpoint row
    $first = reset($bpMap);
    $supported = array_map('intval', array_keys($first)); // e.g. [12,8,6,4,3,2]

    if (in_array($den, $supported, true)) return $den;

    $closest = $supported[0];
    foreach ($supported as $s) {
        if (abs($s - $den) < abs($closest - $den)) {
            $closest = $s;
        }
    }
    return $closest;
}

/**
 * Reduce fraction by gcd.
 */
function kbReduceFraction(int $num, int $den): array
{
    $g = kbGcd($num, $den);
    return [(int)($num / $g), (int)($den / $g)];
}

function kbGcd(int $a, int $b): int
{
    $a = abs($a);
    $b = abs($b);
    while ($b !== 0) {
        $t = $b;
        $b = $a % $b;
        $a = $t;
    }
    return $a === 0 ? 1 : $a;
}

/**
 * Pick the closest allowed fraction (by numeric value).
 */
function kbClosestAllowedFraction(int $num, int $den): array
{
    $target = $num / $den;

    $best = [1, 1];
    $bestDiff = INF;

    foreach (KB_GRID_ALLOWED_FRACTIONS as $key) {
        [$n, $d] = array_map('intval', explode('-', $key));
        $value = $n / $d;
        $diff = abs($value - $target);

        if ($diff < $bestDiff) {
            $bestDiff = $diff;
            $best = [$n, $d];
        }
    }
    return $best;
}
