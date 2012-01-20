<?php

include('functions.php');

printf("%s %s\n%s %s\n%s %s\n%s %s\n", 'freek', Functions::hashPass('freek'), 'ivan', Functions::hashPass('ivan'), 'vincent', Functions::hashPass('vincent'), 'david', Functions::hashPass('david'));