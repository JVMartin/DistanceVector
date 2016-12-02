<?php

namespace DV;

class Node
{
	/**
	 * A string containing this Node's label.  (e.g. 'A')
	 */
	public $label;

	/**
	 * This node's distance vector.  Is of the form:
	 * ['A' => INF, 'B' => 2, ...]
	 */
	private $dv = [];

	/**
	 * An array of references to this Node's neighbor Nodes.
	 */
	private $neighbors = [];

	/**
	 * An array of this Node's neighbors' distance vectors.
	 * (Each distance vector is the same form as the distance vector property above.)
	 */
	private $nDVs      = [];

	/**
	 * An array of N label strings, one for each node in the graph.
	 */
	private $labels = [];

	/**
	 * Node constructor.
	 *
	 * @param $label string This Node's label.
	 * @param array $labels An array of N label strings, one for each node in the graph.
	 */
	public function __construct($label, array $labels)
	{
		$this->labels = $labels;
		$this->label  = $label;

		// Initialize our distance vector to infinity.
		foreach ($this->labels as $l) {
			$this->dv[$l] = INF;
		}

		// Except - set the distance to ourself to 0.
		$this->dv[$this->label] = 0;
	}

	/**
	 * Add a neighbor to this node.
	 *
	 * @param Node $node The reference to the neighbor.
	 * @param $weight int The cost of the path between this node and the neighbor.
	 */
	public function addNeighbor(Node $node, $weight)
	{
		$this->neighbors[$node->label] = $node;
		$this->dv[$node->label]        = $weight;
		$this->nDVs[$node->label]      = [];

		foreach ($this->labels as $l) {
			$this->nDVs[$node->label][$l] = INF;
		}
	}

	/**
	 * Give our neighbor nodes our distance vector.
	 */
	public function updateNeighbors()
	{
		foreach ($this->neighbors as $neighbor) {
			$neighbor->updateDV($this->label, $this->dv);
		}
	}

	/**
	 * Receive a distance vector from a neighbor.
	 *
	 * @param $label string The label of the neighbor.
	 * @param array $dv The neighbor's distance vector.
	 */
	private function updateDV($label, array $dv)
	{
		$this->nDVs[$label] = $dv;
	}

	/**
	 * Recalculate this node's distance vector based on the neighbors' distance vectors.
	 *
	 * @return bool True if there were changes/updates; false otherwise.
	 */
	public function recalc()
	{
		$updates = false;

		// Loop through each neighbor's distance vector.
		foreach ($this->nDVs as $nLabel => $nDV) {
			// Calculate the cost.  If it's less than the current cost, update our distance vector.
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
		return implode("\t", $this->dv);
	}
}