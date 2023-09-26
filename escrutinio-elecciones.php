<?php
/**
 * 
 * 
 * Plugin Name:		Escrutinio Elecciones
 * Plugin URI:		https://quierohacertuweb.com
 * Description:		Muestra resultados de Elecciones.
 * Version:			0.2
 * Author:			Yael Duckwen
 * Author URI:		https://quierohacertuweb.com
 *
*/

// Registrar el tipo de contenido personalizado "Candidatos" y el metabox "Detalles"
function registrar_candidatos_custom_post_type() {
	$labels = array(
		'name' => 'Candidatos',
		'singular_name' => 'Candidato',
		'menu_name' => 'Candidatos',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-businessman',
		'supports' => array('title', 'custom-fields', 'thumbnail'),
	);

	register_post_type('candidato', $args);

	// Registrar una taxonomía personalizada llamada "candidato-election" para tu CPT
	$taxonomy_args = array(
        'hierarchical' => true, // Si deseas que las categorías sean jerárquicas
        'labels' => array(
        	'name' => 'Elecciones',
        	'singular_name' => 'Eleccion',
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    );

	register_taxonomy('candidato-election', 'candidato', $taxonomy_args);

    // Agregar el metabox "Detalles"
	add_action('add_meta_boxes', 'agregar_metabox_detalles');
}



/* Listado de Candidatos */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
// Agregar columnas personalizadas a la tabla de CPT "Candidatos"
function agregar_columnas_personalizadas($columns) {
	$columns['partido'] = 'Partido';
	$columns['votos'] = 'Votos (%)';
	$columns['puesto'] = 'Puesto';
	return $columns;
}
add_filter('manage_candidato_posts_columns', 'agregar_columnas_personalizadas');

// Rellenar el contenido de las columnas personalizadas
function rellenar_columnas_personalizadas($column, $post_id) {
	switch ($column) {
		case 'partido':
		$partido = get_post_meta($post_id, 'partido', true);
		echo esc_html($partido);
		break;

		case 'votos':
		$votos = get_post_meta($post_id, 'votos', true);
		echo esc_html($votos) . '%';
		break;

		case 'puesto':
		$puesto = get_post_meta($post_id, 'puesto', true);
		echo esc_html($puesto);
		break;

		default:
		break;
	}
}
add_action('manage_candidato_posts_custom_column', 'rellenar_columnas_personalizadas', 10, 2);



/* Editor de Candidatos RAPIDO */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function editar_rapido_campo_votos($column_name, $post_type) {
	if ($column_name === 'votos' && $post_type === 'candidato') {
		?>
		<fieldset class="inline-edit-col-left">
			<div class="inline-edit-col">
				<label for="votos" class="inline-edit-group">Votos (%):</label>
				<input type="number" step="0.01" min="0" max="100" name="votos" class="votos" value="<?php echo esc_attr(get_post_meta($post_id, 'votos', true)); ?>">
			</div>
		</fieldset>
		<?php
	}
}

function guardar_valores_rapidos_votos($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!current_user_can('edit_post', $post_id)) return;

	if (isset($_REQUEST['votos'])) {
		update_post_meta($post_id, 'votos', floatval($_REQUEST['votos']));
	}
}

// Agregar la edición rápida para el campo "Votos"
add_action('quick_edit_custom_box', 'editar_rapido_campo_votos', 10, 2);
add_action('save_post', 'guardar_valores_rapidos_votos');


/* Editor de Candidatos */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* Metabox Detalles */
function agregar_metabox_detalles() {
	add_meta_box(
		'ee-metabox-detalles',
		'Detalles',
		'mostrar_metabox_detalles',
		'candidato', /* CPT name */
		'normal',
		'high'
	);
}

function mostrar_metabox_detalles($post) {
	/* Recuperar valores de los campos Partido, Votos y Puesto */
	$partido = get_post_meta($post->ID, 'partido', true);
	$votos = get_post_meta($post->ID, 'votos', true);
	$puesto = get_post_meta($post->ID, 'puesto', true);

	/* Opciones para el campo select "Puesto" */
	$opciones_puesto = array(
		'intendente' => 'Intendente',
		'gobernador' => 'Gobernador',
		'presidente' => 'Presidente',
	);

	/* Mostrar el formulario del metabox */
	echo '<div class="mb">';
	echo '<label for="partido">Partido:</label>';
	echo '<input type="text" id="partido" name="partido" value="' . esc_attr($partido) . '" />';
	echo '</div>';

	echo '<div class="mb">';
	echo '<label for="puesto">Puesto:</label>';
	echo '<select id="puesto" name="puesto">';
	foreach ($opciones_puesto as $valor => $nombre) {
		echo '<option value="' . esc_attr($valor) . '" ' . selected($puesto, $valor, false) . '>' . esc_html($nombre) . '</option>';
	}
	echo '</select>';
	echo '</div>';

	echo '<div class="mb">';
	echo '<label for="votos">Votos (%):</label>';
	echo '<input type="number" id="votos" name="votos" step="0.01" min="0" max="100" value="' . esc_attr($votos) . '" />';
	echo '</div>';
}

function guardar_metabox_detalles($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!current_user_can('edit_post', $post_id)) return;

	// Guardar valores de los campos Partido, Votos y Puesto
	if (isset($_POST['partido'])) {
		update_post_meta($post_id, 'partido', sanitize_text_field($_POST['partido']));
	}

	if (isset($_POST['votos'])) {
		update_post_meta($post_id, 'votos', floatval($_POST['votos']));
	}

	if (isset($_POST['puesto'])) {
		update_post_meta($post_id, 'puesto', sanitize_text_field($_POST['puesto']));
	}
}

add_action('init', 'registrar_candidatos_custom_post_type');
add_action('save_post', 'guardar_metabox_detalles');



/* Shortcode */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

// Shortcode para mostrar una tabla con los candidatos
function mostrar_candidatos_shortcode($atts) {
    // Establece los valores predeterminados para los atributos
	$atts = shortcode_atts(array(
		'eleccion' => '',
		'mesas-intendente' => '',
		'mesas-gobernador' => '',
		'mesas-presidente' => '',
		'fuente' => '',
		'actualizacion' => '',
	), $atts);

	/* Configura los argumentos para la consulta basada en los atributos */
	$args = array(
        'post_type' => 'candidato', // Nombre del tipo de contenido personalizado
        'posts_per_page' => -1,
    );

    // Agrega la categoría a los argumentos si se especifica
	if (!empty($atts['eleccion'])) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'candidato-election', /* Nombre de la taxonomía personalizada */
				'field' => 'slug',
				'terms' => $atts['eleccion'],
			),
		);
	}

    // Consulta para obtener los candidatos
	$candidatos_query = new WP_Query($args);

	$candidatos = array();

	if ($candidatos_query->have_posts()) {
		while ($candidatos_query->have_posts()) {
			$candidatos_query->the_post();
			$nombre = get_the_title();
			$partido = get_post_meta(get_the_ID(), 'partido', true);
			$votos = get_post_meta(get_the_ID(), 'votos', true);
			$puesto = get_post_meta(get_the_ID(), 'puesto', true);
			$imagen_destacada = get_the_post_thumbnail(get_the_ID(), 'thumbnail'); // Obtener la imagen destacada
			$candidatos[] = array(
				'nombre' => $nombre,
				'partido' => $partido,
				'votos' => $votos,
				'puesto' => $puesto,
				'imagen_destacada' => $imagen_destacada, // Agregar la imagen destacada
			);
		}
		wp_reset_postdata();
	}

    // Cargar y mostrar la plantilla personalizada
	ob_start();
	include plugin_dir_path(__FILE__) . 'templates/tabs.php';
	return ob_get_clean();
}
add_shortcode('mostrar_candidatos', 'mostrar_candidatos_shortcode');



/* Añadir Estilos */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

function cargar_estilo_admin() {
	$css_url = plugins_url('ee-admin.css', __FILE__);
	wp_enqueue_style('ee-estilo-admin', $css_url);
}
add_action('admin_enqueue_scripts', 'cargar_estilo_admin');

function enqueue_ee_frontend_styles() {
	$css_url = plugins_url('ee-style.css', __FILE__);
	wp_enqueue_style('ee-estilo-frontend', $css_url);
	wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
}
add_action('wp_enqueue_scripts', 'enqueue_ee_frontend_styles');

function load_jquery() {
	wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'load_jquery');
