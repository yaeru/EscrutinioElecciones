<table class="table custom-candidates-table">
	<thead>
		<tr>
			<th>Puesto</th>
			<th>Nombre</th>
			<th>Partido</th>
			<th>Votos (%)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($candidatos as $candidato) : ?>
			<tr>
				<td><?php echo esc_html($candidato['puesto']); ?></td>
				<td><?php echo esc_html($candidato['nombre']); ?></td>
				<td><?php echo esc_html($candidato['partido']); ?></td>
				<td><?php echo esc_html($candidato['votos']); ?>%</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<style type="text/css">
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
