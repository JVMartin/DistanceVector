<?php

namespace DV;

class Graph
{
	/**
	 * An array of Node objects.
	 */
	private $nodes = [];

	/**
	 * Graph constructor.
	 *
	 * @param array $labels An array of node labels.
	 */
	public function __construct(array $labels)
	{
		// Loop through the array of node labels and create a new node for each one.
		foreach ($labels as $label) {
			$this->nodes[$label] = new Node($label, $labels);
		}
	}

	/**
	 * Make nodes A and B neighbors of each other.
	 *
	 * @param $a string The label of node A.
	 * @param $b string The label of node B.
	 * @param $weight int The weight of the path between them.
	 */
	public function addEdge($a, $b, $weight)
	{
		$nodeA = $this->nodes[$a];
		$nodeB = $this->nodes[$b];

		$nodeA->addNeighbor($nodeB, $weight);
		$nodeB->addNeighbor($nodeA, $weight);
	}

	/**
	 * Run through the algorithm once.
	 *
	 * @return bool If there were updates, return true.  Otherwise, return false.
	 */
	public function iterate()
	{
		$updates = false;

		// First, let each node update its neighbors with its DV.
		foreach ($this->nodes as $node) {
			$node->updateNeighbors();
		}

		// Next, let each node recalculate its DV.
		foreach ($this->nodes as $node) {
			if ($node->recalc()) {
				$updates = true;
			}
		}

		// If there were updates, return true.  Otherwise, return false.
		return $updates;
	}

	/**
	 * Step through the algorithm, displaying the new DV's at each step.
	 */
	public function showSteps()
	{
		$i = 0;
		do {
			echo "\nStep " . $i++;
			echo "\n---------------------------------\n";
			echo $this;
		} while($this->iterate());
	}

	public function __toString()
	{
		$s = " \t";
		foreach ($this->nodes as $node) {
			$s .= $node->label . "\t";
		}
		$s .= "\n";
		foreach ($this->nodes as $node) {
			$s .= $node->label . "\t" . $node . "\n";
		}
		return $s;
	}
}