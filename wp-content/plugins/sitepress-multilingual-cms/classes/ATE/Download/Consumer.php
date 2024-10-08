<?php

namespace WPML\TM\ATE\Download;

use Exception;
use WPML\FP\Obj;
use WPML\TM\ATE\ReturnedJobs;
use WPML_TM_ATE_API;
use WPML_TM_ATE_Jobs;

class Consumer {

	/** @var WPML_TM_ATE_API $ateApi */
	private $ateApi;

	/** @var WPML_TM_ATE_Jobs $ateJobs */
	private $ateJobs;

	public function __construct( WPML_TM_ATE_API $ateApi, WPML_TM_ATE_Jobs $ateJobs ) {
		$this->ateApi  = $ateApi;
		$this->ateJobs = $ateJobs;
	}

	/**
	 * @param  $job
	 *
	 * @return array|\stdClass|false
	 * @throws Exception
	 */
	public function process( $job ) {
		$xliffContent = $this->ateApi->get_remote_xliff_content( Obj::prop( 'url', $job ), $job );
		$wpmlJobId    = $this->ateJobs->apply( $xliffContent );

		if ( $wpmlJobId ) {
			$job = Obj::assoc( 'jobId', $wpmlJobId, $job );
			$job = Obj::assoc( 'status', ICL_TM_COMPLETE, $job );

			return $job;
		}

		return false;
	}
}
