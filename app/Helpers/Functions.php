<?php

function CalculatePagination($count, $start) {
    $pagination = [];
    $numPages = (int)(($count - 1)/15) + 1;
    $curPage = (int)($start/15) + 1;
    if ($numPages <= 9) {
        // Display all pages
        for ($i = 1; $i <= $numPages; $i++) {
            $calc = ($i - 1) * 15;
            $pagination[] = ["{$i}" => "{$calc}"];
        }
    } else if ($numPages > 9 && $curPage <= 5) {
        // Display 1 to 7, ..., last page
        for ($i = 1; $i <= 7; $i++) {
            $calc = ($i - 1) * 15;
            $pagination[] = ["{$i}" => "{$calc}"];
        }
        $pagination[] = ["8" => "..."];
        $pagination[] = ["{$numPages}" => "" . (($numPages - 1) * 15)];
    } else if ($numPages > 9 && $numPages - $curPage > 4) {
        // Display 1, ..., curpage-2 to curpage +2, ..., last page
        $pagination[] = ["1" => "0"];
        $pagination[] = ["2" => "..."];
        for ($i = $curPage - 2; $i <= $curPage + 2; $i++) {
            $calc = ($i - 1) * 15;
            $pagination[] = ["{$i}" => "{$calc}"];
        }
        $pagination[] = ["8" => "..."];
        $pagination[] = ["{$numPages}" => "" . (($numPages - 1) * 15)];
    } else if ($numPages > 9) {
        // Display 1, ..., last-7 to last page
        $pagination[] = ["1" => "0"];
        $pagination[] = ["2" => "..."];
        for ($i = $numPages - 6; $i <= $numPages; $i++) {
            $calc = ($i - 1) * 15;
            $pagination[] = ["{$i}" => "{$calc}"];
        }
    }
    return $pagination;
}

