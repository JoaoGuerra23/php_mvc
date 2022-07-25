<?php

/**
 *
 * Simple page redirect
 *
 * @param $page
 * @return void
 */
function redirect($page)
{
    header('location: ' . URLROOT . '/' . $page);
}