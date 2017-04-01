<?php
  session_start();
  session_destroy();
  unset($_SESSION);
  echo "Session Destroied";
