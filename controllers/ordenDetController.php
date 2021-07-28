<?php

include '../models/orden.php';

$ordenes = new Orden;

$ordenes -> obtenerOrden($id);
