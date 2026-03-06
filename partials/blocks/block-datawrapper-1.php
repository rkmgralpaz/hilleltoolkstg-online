<?php

$chartId = 'GTSFP';

$apiToken = 'dUVp1mJ6ZNNp8TA1tHsjwAKz2yLysBaipm3Qp4HSGTkUBaLQYw5hSnGGz67USggK';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.datawrapper.de/v3/charts/$chartId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $apiToken",
    ),
));

$response_meta = curl_exec($curl);

if (curl_errno($curl)) {
    echo '<pre>Error: ' . curl_error($curl) . '</pre>';
    curl_close($curl);
    exit();
}

$chart_metadata = json_decode($response_meta, true);

$chart_title = isset($chart_metadata['title']) ? $chart_metadata['title'] : 'Title not available';

$chart_notes = isset($chart_metadata['metadata']['annotate']['notes']) ? $chart_metadata['metadata']['annotate']['notes'] : 'Description not available';

$chart_source = isset($chart_metadata['metadata']['describe']['source-name']) ? $chart_metadata['metadata']['describe']['source-name'] : 'Source not available';

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.datawrapper.de/v3/charts/$chartId/data",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $apiToken",
    ),
));

$response_data = curl_exec($curl);

if (curl_errno($curl)) {
    echo '<pre>Error: ' . curl_error($curl) . '</pre>';
} else {
    $lines = explode("\n", trim($response_data));
    $data_array = [];
    $max_total = 0;

    // Primer paso: Recorrer y construir el array, además de identificar el total máximo
    foreach ($lines as $line) {
        // Dividir cada línea por tabulaciones
        $parts = explode("\t", $line);
        if (count($parts) == 2) {
            $year = $parts[0];
            $total = (int)$parts[1];
            $data_array[$year] = [
                'total' => $total,
            ];
            $max_total = max($max_total, $total); // Identificar el total máximo
        }
    }

    // Segundo paso: Calcular el porcentaje respecto al máximo para cada valor
    foreach ($data_array as $year => $data) {
        $data_array[$year]['percentage_of_max'] = ($max_total > 0) ? ($data['total'] / $max_total) * 100 : 0; // Calcular el porcentaje
    }

    // Calcular el crecimiento específico entre 2021-2022 y 2023-2024
    if (isset($data_array['2021-2022']) && isset($data_array['2023-2024'])) {
        $total_2021_2022 = $data_array['2021-2022']['total'];
        $total_2023_2024 = $data_array['2023-2024']['total'];

        // Fórmula para el crecimiento porcentual
        $growth_specific = (($total_2023_2024 - $total_2021_2022) / $total_2021_2022) * 100;
    } else {
        $growth_specific = null;
    }
}

curl_close($curl);

?>

<div class="block-datawrapper-1-wrap theme theme--neutral theme--mode-light">

	<div class="block-datawrapper-1">

        <div class="block-datawrapper-1__divider"></div>

        <div class="block-datawrapper-1__top max-width">

            <div class="block-datawrapper-1__title" data-animate="fade-in-up">
                <div class="font-heading-md theme__text--primary">
				<?php echo esc_html(wp_strip_all_tags($chart_title)); ?>

                </div>
            </div>

            <div class="block-datawrapper-1__source block-datawrapper-1__source--desktop font-body-sm theme__text--secondary" data-animate="fade-in-up">
                <div>
                <?php echo $chart_notes;  ?>          
                </div>
                <div>
                Source: <?php echo $chart_source;  ?>          
                </div>
            </div>

        </div>

        <div class="block-datawrapper-1__divider"></div>

		<div class="block-datawrapper-1__body-wrap">

			<div class="block-datawrapper-1__body">
				<div class="block-datawrapper-1__featured block-datawrapper-1__featured--desktop font-display-xl " data-animate="fade-in-up">
					<div class="block-datawrapper-1__featured-top">
						<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 186 230" fill="none">
							<path d="M93 230L93 6.00007" stroke="#4B7EFD" stroke-width="8"/>
							<path d="M3 95.811L92.8108 6.00006L182.622 95.811" stroke="#4B7EFD" stroke-width="8"/>
						</svg>
						<div class="block-datawrapper-1__featured-percentage">
							<?php echo $block['featured_stat']; ?>
						</div>
					</div>
					<div class="block-datawrapper-1__featured-bottom font-body-md theme__text--secondary">
					<?php echo $block['text']; ?>
					</div>
				</div>
	
				<div class="bar-graph" >
	
				<?php $previous_total = null;  ?>
	
				<?php  foreach ($data_array as $rango_years => $data) {  ?>
	<?php 
		
		$ifdf = ($data['total'] / $max_total) * 100;
		?>
					
					<div class="bar-graph__bar" data-animate="fade-in-up" data-animate-delay="100">
						<div class="bar-graph__info">
							<div class="bar-graph__total font-heading-md theme__text--primary">
								<?php echo round($data['total']); ?>
							</div>
	
							<?php if ($previous_total !== null) { 
								$growth_percentage = (($data['total'] - $previous_total) / $previous_total) * 100; 
								$is_negative = $growth_percentage < 0;
								$growth_svg_class = $is_negative ? 'svg-negative' : 'svg-positive';
								?>
	
								<div class="bar-graph__percent font-body-md theme__text--secondary">
									<?php if ($growth_svg_class == 'svg-positive' ) { ?>
										<svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M9.54971 5.23987L5.01704 9.77255L3.24927 8.00479L9.91593 1.33811L10.7998 0.454224L11.6837 1.33811L18.3504 8.00479L16.5826 9.77255L12.0497 5.23966L12.0497 18.8887H9.54972L9.54971 5.23987Z" fill="#4B7EFD"/>
										</svg>
									<?php } else { ?>
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2503 14.7601L15.783 10.2274L17.5507 11.9952L10.8841 18.6619L10.0002 19.5458L9.11631 18.6619L2.44965 11.9952L4.21741 10.2274L8.7503 14.7603L8.7503 1.11133L11.2503 1.11133L11.2503 14.7601Z" fill="#4B7EFD"/>
										</svg>
									<?php } ?>
									
									<div>
										<?php echo round(abs($growth_percentage)); ?>%
									</div>
								</div>
	
							<?php } ?>
	
						</div>
	
						<div class="bar-graph__candle" style="height: <?php echo round($data['percentage_of_max']); ?>%; width: calc( <?php echo round($data['percentage_of_max']); ?>% - 10px)">
						</div>
						
					</div>
					
					<?php $previous_total = $data['total']; ?>   
	
				   <?php } ?>
	
				</div>
	
			</div>
	
			<div class="block-datawrapper-1__divider"></div>
	
			<div class="block-datawrapper-1__bottom">
				<div>
				<?php foreach ($data_array as $rango_years => $data) { ?>
					<div class="theme__text--secondary">
					<div class="block-datawrapper-1__year">
						<?php
						$years = explode('-', $rango_years);
						if (count($years) == 2) {
							echo $years[0] . '-';
							echo '<span class="hide">' . substr($years[1], 0, 2) . '</span>' . substr($years[1], 2);
						} else {
							echo $rango_years;
						}
						?>
					</div>

					</div>
				<?php } ?>
				</div>
			</div>

		</div>

		<div class="block-datawrapper-1__mobile">

		<div class="block-datawrapper-1__divider"></div>
			<div class="block-datawrapper-1__source block-datawrapper-1__source--mobile font-body-sm theme__text--secondary" data-animate="fade-in-up">
				<div>
				<?php echo $chart_notes;  ?>          
				</div>
				<div>
				Source: <?php echo $chart_source;  ?>          
				</div>
			</div>
			<div class="block-datawrapper-1__divider"></div>
			<div class="block-datawrapper-1__featured block-datawrapper-1__featured--mobile font-display-xl " data-animate="fade-in-up">
				<div class="block-datawrapper-1__featured-top">
					<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 186 230" fill="none">
						<path d="M93 230L93 6.00007" stroke="#4B7EFD" stroke-width="8"/>
						<path d="M3 95.811L92.8108 6.00006L182.622 95.811" stroke="#4B7EFD" stroke-width="8"/>
					</svg>
					<div class="block-datawrapper-1__featured-percentage">
						<?php if ($growth_specific !== null) { echo round(abs($growth_specific)); } ?>%
					</div>
				</div>
				<div class="block-datawrapper-1__featured-bottom font-body-md theme__text--secondary">
				<?php echo $block['text']; ?>
				</div>
			</div>
			<div class="block-datawrapper-1__divider"></div>
		</div>




	</div>

</div>

