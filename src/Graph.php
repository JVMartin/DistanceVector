<?php

namespace DV;

class Graph
{
	private $nodes = [];

	public function __construct(array $labels)
	{
		foreach ($labels as $label) {
			$this->nodes[$label] = new Node($label, $labels);
		}
	}

	public function __toString()
	{
		$s = '';
		foreach ($this->nodes as $node) {
			$s .= $node->label . ': ' . $node . "\n";
		}
		return $s;
	}

	public function addEdge($a, $b, $weight)
	{
		$nodeA = $this->nodes[$a];
		$nodeB = $this->nodes[$b];

		$nodeA->addNeighbor($nodeB, $weight);
		$nodeB->addNeighbor($nodeA, $weight);
	}

	public function iterate()
	{
		$updates = false;
		foreach ($this->nodes as $node) {
			$node->updateNeighbors();
		}
		foreach ($this->nodes as $node) {
			if ($node->recalc()) {
				$updates = true;
			}
		}
		return $updates;
	}

	public function showSteps()
	{
		$i = 0;
		do {
			echo "\nStep " . $i++;
			echo "\n---------------------------------\n";
			echo $this;
		} while($this->iterate());
	}
}