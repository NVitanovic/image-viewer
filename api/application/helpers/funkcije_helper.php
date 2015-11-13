<?php

	function response($status = 'ok', $info = '', $data = '')
	{
		return array(
				'status' 	=> $status,
				'info'		=> $info,
				'data' 		=> $data
			);
	}