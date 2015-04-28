<?php
namespace TYPO3\Surf\CMS\Task\TYPO3\CMS;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.Surf.CMS".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Composer\Exception\InvalidConfigurationException;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Flow\Annotations as Flow;

/**
 * This task create new tables or add new fields to them.
 * This task requires the extension coreapi.
 */
class CompareDatabaseTask extends AbstractCliTask {

	/**
	 * Execute this task
	 *
	 * @param \TYPO3\Surf\Domain\Model\Node $node
	 * @param \TYPO3\Surf\Domain\Model\Application $application
	 * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
	 * @param array $options
	 * @throws InvalidConfigurationException
	 * @return void
	 */
	public function execute(Node $node, Application $application, Deployment $deployment, array $options = array()) {
		if (!$this->packageExists('coreapi', $node, $application, $deployment, $options)) {
			throw new InvalidConfigurationException('Extension "coreapi" is not found! Make sure it is available in your project, or remove this task in your deployment configuration!', 1405527176);
		}
		$databaseCompareMode = isset($options['databaseCompareMode']) ? $options['databaseCompareMode'] : '2,4';
		$this->executeCliCommand(
			array('typo3/cli_dispatch.phpsh', 'extbase', 'databaseapi:databasecompare', $databaseCompareMode),
			$node,
			$application,
			$deployment,
			$options
		);
	}
}
