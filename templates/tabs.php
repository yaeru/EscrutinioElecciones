<?php 
$mesas = $atts['mesas'];
$fuente = $atts['fuente'];
$actualizacion = $atts['actualizacion'];

/* Función de comparación personalizada para ordenar los candidatos por votos de mayor a menor */
// function ordenar_por_votos($a, $b) {
// 	return $b['votos'] - $a['votos'];
// }

/* Ordenar los candidatos utilizando la función de comparación personalizada */
//usort($candidatos, 'ordenar_por_votos');
?>
<div class="candidatos-tabs">
	<ul class="nav nav-pills  nav-fill" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="intendente-tab" data-toggle="tab" href="#intendente" role="tab" aria-controls="intendente" aria-selected="true">Intendente</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="gobernador-tab" data-toggle="tab" href="#gobernador" role="tab" aria-controls="gobernador" aria-selected="false">Gobernador</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="presidente-tab" data-toggle="tab" href="#presidente" role="tab" aria-controls="presidente" aria-selected="false">Presidente</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade show active" id="intendente" role="tabpanel" aria-labelledby="intendente-tab">
			<h3 class="mt-3">Intendente</h3>
			<div class="custom-candidates-grid">
				<?php
				foreach ($candidatos as $candidato) {
					if ($candidato['puesto'] === 'intendente') {
						echo '<article class="card">';
						echo '<div class="candidato-cara">' . $candidato['imagen_destacada'] . '</div>';
						echo '<div class="candidato-votos">' . esc_html($candidato['votos']) . '%</div>';
						echo '<div class="candidato-nombre">' . esc_html($candidato['nombre']) . '</div>';
						echo '<div class="candidato-partido">' . esc_html($candidato['partido']) . '</div>';
						echo '</article>';
					}
				}
				?>
			</div>
		</div>


		<div class="tab-pane fade" id="gobernador" role="tabpanel" aria-labelledby="gobernador-tab">
			<h3 class="mt-3">Gobernador</h3>
			<div class="custom-candidates-grid">
				<?php
				foreach ($candidatos as $candidato) {
					if ($candidato['puesto'] === 'gobernador') {
						echo '<article class="card">';
						echo '<div class="candidato-votos">' . esc_html($candidato['votos']) . '%</div>';
						echo '<div class="candidato-nombre">' . esc_html($candidato['nombre']) . '</div>';
						echo '<div class="candidato-partido">' . esc_html($candidato['partido']) . '</div>';
						echo '</article>';
					}
				}
				?>
			</div>
		</div>

		<div class="tab-pane fade" id="presidente" role="tabpanel" aria-labelledby="presidente-tab">
			<h3 class="mt-3">Presidente</h3>
			<div class="custom-candidates-grid">
				<?php
				foreach ($candidatos as $candidato) {
					if ($candidato['puesto'] === 'presidente') {
						echo '<article class="card">';
						echo '<div class="candidato-votos">' . esc_html($candidato['votos']) . '%</div>';
						echo '<div class="candidato-nombre">' . esc_html($candidato['nombre']) . '</div>';
						echo '<div class="candidato-partido">' . esc_html($candidato['partido']) . '</div>';
						echo '</article>';
					}
				}
				?>
			</div>
		</div>

	</div>
</div>

<div>
	<ul>
		<li>Mesas escrutadas: <?php echo esc_html($mesas); ?> %</li>
		<li>Fuente: <?php echo esc_html($fuente); ?></li>
		<li>Actualización: <?php echo esc_html($actualizacion); ?> hs</li>
	</ul>
</div>

<style type="text/css">
	.custom-candidates-grid {
		text-align: center;
		display: grid;
		gap: 1rem;
		grid-template-columns: repeat(3,1fr);
		/*
		grid-template-columns: repeat(5,200px);
		
		text-transform: capitalize;
		overflow-x: scroll;
		overflow-y: hidden;
		scroll-direction: horizontal;
		-webkit-overflow-scrolling: touch;*/
	}
	.custom-candidates-grid .card {
		padding: 1rem;
		border: solid 1px;
		border-radius: 5px;
	}
	.candidato-cara img {
		max-width: 100px;
		height: auto;
		border-radius: 100px;
	}
	.candidato-votos {
		font-size: 3rem;
		font-weight: bold;
	}
	.candidato-nombre {
		font-size: 1.5rem;
		font-weight: bold;
	}
	.candidato-partido {
		font-size: 1rem;
	}

	.custom-candidates-table {
		width: 100%;
		border-collapse: collapse;
		text-transform: capitalize;
	}

	.custom-candidates-table th {
		background-color: #f2f2f2;
		text-align: left;
		padding: 10px;
	}

	.custom-candidates-table tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	.custom-candidates-table tr:nth-child(odd) {
		background-color: #ffffff;
	}

	.custom-candidates-table td {
		padding: 10px;
		border-bottom: 1px solid #ccc;
	}

</style>
