<?php 
$mesas_intendente = $atts['mesas-intendente'];
$mesas_gobernador = $atts['mesas-gobernador'];
$mesas_presidente = $atts['mesas-presidente'];
$fuente = $atts['fuente'];
$actualizacion = $atts['actualizacion'];

/* Función de comparación personalizada para ordenar los candidatos por votos de mayor a menor */
function ordenar_por_votos($a, $b) {
	return $b['votos'] - $a['votos'];
}

/* Ordenar los candidatos utilizando la función de comparación personalizada */
usort($candidatos, 'ordenar_por_votos');
?>
<div class="candidatos-tabs">
	<ul id="ee-nav-pills" class="nav nav-pills  nav-fill" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="presidente-tab" data-toggle="tab" href="#presidente" role="tab" aria-controls="presidente" aria-selected="false">Presidente</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="gobernador-tab" data-toggle="tab" href="#gobernador" role="tab" aria-controls="gobernador" aria-selected="false">Gobernador</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="intendente-tab" data-toggle="tab" href="#intendente" role="tab" aria-controls="intendente" aria-selected="true">Intendente</a>
		</li>
		
		
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade" id="intendente" role="tabpanel" aria-labelledby="intendente-tab">
			<h3 class="mt-3 ee-puesto-title">Intendente</h3>
			<div class="ee-candidates-grid">
				<?php
				foreach ($candidatos as $candidato) {
					if ($candidato['puesto'] === 'intendente') {
						echo '<article class="card">';
						echo '<div class="candidato-cara">' . $candidato['imagen_destacada'] . '</div>';
						echo '<div class="candidato-votos">' . esc_html($candidato['votos']) . '%</div>';
						echo '<div class="candidato-data">';
						echo '<div class="candidato-nombre">' . esc_html($candidato['nombre']) . '</div>';
						echo '<div class="candidato-partido">' . esc_html($candidato['partido']) . '</div>';
						echo '</div>';
						echo '</article>';
					}
				}
				?>
			</div>

			<div class="ee-fuentes mt-4">
				<ul>
					<li>Mesas escrutadas: <strong><?php echo esc_html($mesas_intendente); ?>%</strong></li>
					<li>Fuente: <strong><?php echo esc_html($fuente); ?></strong></li>
					<li>Actualización: <strong><?php echo esc_html($actualizacion); ?> hs</strong></li>
				</ul>
			</div>
		</div>

		<div class="tab-pane fade" id="gobernador" role="tabpanel" aria-labelledby="gobernador-tab">
			<h3 class="mt-3 ee-puesto-title">Gobernador</h3>
			<div class="ee-candidates-grid">
				<?php
				foreach ($candidatos as $candidato) {
					if ($candidato['puesto'] === 'gobernador') {
						echo '<article class="card">';
						echo '<div class="candidato-cara">' . $candidato['imagen_destacada'] . '</div>';
						echo '<div class="candidato-votos">' . esc_html($candidato['votos']) . '%</div>';
						echo '<div class="candidato-data">';
						echo '<div class="candidato-nombre">' . esc_html($candidato['nombre']) . '</div>';
						echo '<div class="candidato-partido">' . esc_html($candidato['partido']) . '</div>';
						echo '</div>';
						echo '</article>';
					}
				}
				?>
			</div>
			<div class="ee-fuentes mt-4">
				<ul>
					<li>Mesas escrutadas: <strong><?php echo esc_html($mesas_gobernador); ?>%</strong></li>
					<li>Fuente: <strong><?php echo esc_html($fuente); ?></strong></li>
					<li>Actualización: <strong><?php echo esc_html($actualizacion); ?> hs</strong></li>
				</ul>
			</div>
		</div>

		<div class="tab-pane fade show active" id="presidente" role="tabpanel" aria-labelledby="presidente-tab">
			<h3 class="mt-3 ee-puesto-title">Presidente</h3>
			<div class="ee-candidates-grid">
				<?php
				foreach ($candidatos as $candidato) {
					if ($candidato['puesto'] === 'presidente') {
						echo '<article class="card">';
						echo '<div class="candidato-cara">' . $candidato['imagen_destacada'] . '</div>';
						echo '<div class="candidato-votos">' . esc_html($candidato['votos']) . '%</div>';
						echo '<div class="candidato-data">';
						echo '<div class="candidato-nombre">' . esc_html($candidato['nombre']) . '</div>';
						echo '<div class="candidato-partido">' . esc_html($candidato['partido']) . '</div>';
						echo '</div>';
						echo '</article>';
					}
				}
				?>
			</div>
			<div class="ee-fuentes mt-4">
				<ul>
					<li>Mesas escrutadas: <strong><?php echo esc_html($mesas_presidente); ?>%</strong></li>
					<li>Fuente: <strong><?php echo esc_html($fuente); ?></strong></li>
					<li>Actualización: <strong><?php echo esc_html($actualizacion); ?> hs</strong></li>
				</ul>
			</div>
		</div>

	</div>
</div>

<style type="text/css">
	

</style>
