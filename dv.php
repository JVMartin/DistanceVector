<?php

namespace DV;

require __DIR__ . '/vendor/autoload.php';

$graph = new Graph(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']);

$graph->addEdge('A', 'B', 14);
$graph->addEdge('A', 'C', 2);

$graph->addEdge('B', 'C', 8);
$graph->addEdge('B', 'E', 1);
$graph->addEdge('B', 'F', 3);

$graph->addEdge('C', 'G', 1);

$graph->addEdge('D', 'E', 7);
$graph->addEdge('D', 'F', 10);

$graph->addEdge('E', 'F', 1);

$graph->addEdge('F', 'H', 1);
$graph->addEdge('F', 'G', 3);

$graph->addEdge('G', 'H', 5);

$graph->showSteps();