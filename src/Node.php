<?php

namespace DV;

class Node
{
	private $labels;
	public $label;
	private $dv        = [];
	private $neighbors = [];
	private $nDVs      = [];

	public function __construct($label, array $labels)
	{
		$this->labels = $labels;
		$this->label = $label;

		// Initialize our distance vector to infinity.
		foreach ($this->labels as $l) {
			$this->dv[$l] = INF;
		}

		$this->dv[$this->label] = 0;
	}

	public function addNeighbor(Node $node, $weight)
	{
		$this->neighbors[$node->label] = $node;
		$this->dv[$node->label]        = $weight;
		$this->nDVs[$node->label]      = [];

		foreach ($this->labels as $l) {
			$this->nDVs[$node->label][$l] = INF;
		}
	}

	public function updateNeighbors()
	{
		foreach ($this->neighbors as $neighbor) {
			$neighbor->updateDV($this->label, $this->dv);
		}
	}

	private function updateDV($label, array $dv)
	{
		$this->nDVs[$label] = $dv;
	}

	public function recalc()
	{
		$updates = false;
		foreach ($this->nDVs as $nLabel => $nDV) {
			foreach ($nDV as $label => $costFromNeighbor) {
				$cost = $nDV[$this->label] + $costFromNeighbor;
				if ($cost < $this->dv[$label]) {
					$updates = true;
					$this->dv[$label] = $cost;
				}
			}
		}
		return $updates;
	}

	public function __toString()
	{
		return implode(', ', $this->dv);
	}
}