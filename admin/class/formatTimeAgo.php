<?php
    class formatTimeAgo {
        function __construct()
        {
            
        }
        
        function formatTimeAgo($dateString) {
            $timestamp = strtotime($dateString);
            $currentTimestamp = time();
            $diff = $currentTimestamp - $timestamp;
        
            if ($diff < 60) {
                return '1 minutes ago';
            } elseif ($diff < 3600) {
                $minutes = floor($diff / 60);
                return $minutes . ' minutes ago';
            } elseif ($diff < 86400) {
                $hours = floor($diff / 3600);
                return $hours . ' hours ago';
            } elseif ($diff < 2592000) {
                $days = floor($diff / 86400);
                return $days . ' days ago';
            }
        }        
    }
?>