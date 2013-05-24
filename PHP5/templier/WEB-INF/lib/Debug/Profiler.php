<?php
class Debug_Profiler {

	function profile($dbg_prof_results = false)
	{
		if (!$dbg_prof_results) dbg_get_profiler_results(&$dbg_prof_results);

		$ctx_cache = array();
		$contexts = array();
		foreach ($dbg_prof_results["line_no"] as $idx => $line_no) {
			$mod_no = $dbg_prof_results["mod_no"][$idx];
			dbg_get_module_name($mod_no, &$mod_name);
			
			$hit_cnt = $dbg_prof_results["hit_count"][$idx];

			$time_sum = $dbg_prof_results["tm_sum"][$idx] * 1000;
			$time_avg_hit = $time_sum / $hit_cnt;
			$time_min = $dbg_prof_results["tm_min"][$idx] * 1000;
			$time_max = $dbg_prof_results["tm_max"][$idx] * 1000;

			dbg_get_source_context($mod_no, $line_no, &$ctx_id);
			if (@$ctx_cache[$ctx_id]) {
				$ctx_name = $ctx_cache[$ctx_id];
			} else {
				if (dbg_get_context_name($ctx_id, &$ctx_name) && strcmp($ctx_name,"") == 0)
					$ctx_name = "::main";
				$ctx_cache[$ctx_id] = $ctx_name;
			}

			$cont =& $contexts[$ctx_name];
			if (!@$cont) $cont = array(
				"file" => $mod_name,
				'hit_cnt' => 0,
				'time_sum' => 0,
				'lines' => array()
			);

			$cont['hit_cnt'] += $hit_cnt; 
			$cont['time_sum'] += $time_sum;
			$cont['lines'][$line_no] = array(
				"hit_cnt"  => $hit_cnt,
				"time_sum" => $time_sum,
			);
		}

		uasort($contexts, array('Debug_Profiler', 'profile_cmp'));
		foreach ($contexts as $ctx=>$data) {
			uasort($contexts[$ctx]['lines'], array('Debug_Profiler', 'profile_cmp'));
		}
		return $contexts;
	}

	function profile_cmp($x,$y)
	{
		$a = $x["time_sum"];
		$b = $y["time_sum"];
		if ($a == $b) return 0;
	    return ($a > $b) ? -1 : 1;
	}


	function out($contexts=false, $lines_detail = 3)
	{
		if (!@$contexts) $contexts = Debug_Profiler::profile();
		echo "
			<br><table cellspacing=2 cellpadding=2 border=0 style='font:8pt courier'>
		    <thead>
			<tr style='background:#808080; color:#FFFFFF'>
				<td> file </td>
				<td> function </td>
				<td> hit_cnt </td>
				<td> time </td>
				<td> % time </td>
			</tr></thead>
			<tbody style='vertical-align: top'>
		";

		$total_time = $total_hits = 0;
		foreach ($contexts as $context=>$data) {
			$total_time += $data['time_sum'];
			$total_hits += $data['hit_cnt'];
		}

		$idx = 0;
		foreach ($contexts as $context=>$data) {
			$bk = ($idx++ & 1) ? "#ffffff" : "#e0e0e0";
			$file = basename($data['file']);
			$p_time = sprintf("%.3f", 100 * $data['time_sum'] / $total_time);
			echo @"
				<tr style='background:$bk'>
				<td>$file</td>
				<td>$context</td>
				<td>$data[hit_cnt]</td>
				<td>$data[time_sum]</td>
				<td>$p_time</td>
			    </tr>
			";
			if ($idx-1 < $lines_detail) {
				$i = 0;
				foreach ($data['lines'] as $l=>$d) {
					$p_time = sprintf("%.3f", 100 * $d['time_sum'] / $total_time);
					echo @"
						<tr style='background:$bk'>
						<td>...</td>
						<td>&nbsp;&nbsp;line $l</td>
						<td>&nbsp;&nbsp;$d[hit_cnt]</td>
						<td>&nbsp;&nbsp;$d[time_sum]</td>
						<td>&nbsp;&nbsp;$p_time</td>
						</tr>
					";
					if ($i++>20) break;
				}
			}
		}
		echo "</tbody></table>";
	}

	/*
	function dbg_dump_profiling_results() {

	  dbg_get_profiler_results(&$dbg_prof_results);

	  echo "<br><table width=1000 cellspacing=0 cellpadding=2 style='font:8pt courier'>
	    <thead>
	    <tr style='background:#808080; color:#FFFFFF'>
	      <td> module </td>
	      <td> line </td>
	      <td> hits </td>
	      <td> time/hit, ms </td>
	      <td> total time, ms </td>
	      <td> min time, ms </td>
	      <td> max time, ms </td>
	      <td> context ID </td>
	      <td> context </td>
	    </tr></thead>
	    <tbody style='vertical-align: top'>";
	  foreach ($dbg_prof_results["line_no"] as $idx => $line_no) {
	    $mod_no = $dbg_prof_results["mod_no"][$idx];
	    dbg_get_module_name($mod_no, &$mod_name);
	    if (strpos("!".$mod_name, "prof_results.php") > 0) continue;

	    $hit_cnt = $dbg_prof_results["hit_count"][$idx];

	    $time_sum = $dbg_prof_results["tm_sum"][$idx] * 1000;
	    $time_avg_hit = $time_sum / $hit_cnt;
	    $time_min = $dbg_prof_results["tm_min"][$idx] * 1000;
	    $time_max = $dbg_prof_results["tm_max"][$idx] * 1000;

	    $time_sum = sprintf("%.3f", $time_sum);
	    $time_avg_hit = sprintf("%.3f", $time_avg_hit);
	    $time_min = sprintf("%.3f", $time_min);
	    $time_max = sprintf("%.3f", $time_max);

	    dbg_get_source_context($mod_no, $line_no, &$ctx_id);
	    if (dbg_get_context_name($ctx_id, &$ctx_name) && strcmp($ctx_name,"") == 0)
	      $ctx_name = "::main";

	    $bk = "#ffffff";
	    if (($idx & 1) == 0)
	      $bk = "#e0e0e0";

	    echo "<tr style='background:$bk'>
	      <td>$mod_name</td>
	      <td>$line_no</td>
	      <td>$hit_cnt</td>
	      <td>$time_avg_hit</td>
	      <td>$time_sum</td>
	      <td>$time_min</td>
	      <td>$time_max</td>
	      <td>$ctx_id</td>
	      <td>$ctx_name</td>
	    </tr>";
	  }
	  echo "</tbody></table>";
	}
	*/
}
?>