<?php
/**
 * Index
 *
 * Main template of the theme.
 *
 * @package    Short Link Theme
 * @author     Sergio Peña
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Short Links</title>
	<?php wp_head(); ?>
</head>
<body>
	<section id="app" class="container">
		<h1 class="title">Short Links</h1>
		<div class="table-container">
			<table class="sl-table table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
				<thead>
				<tr>
					<th v-on:click="sortTable('id')" >
						ID
						<div class="arrow" v-if="'id' === sortColumn" v-bind:class="[ascending ? 'arrow-up' : 'arrow-down']"></div>
					</th>
					<th v-on:click="sortTable('title')">
						Title
						<div class="arrow" v-if="'title' === sortColumn" v-bind:class="[ascending ? 'arrow-up' : 'arrow-down']"></div>
					</th>
					<th v-on:click="sortTable('permalink')">
						URL
						<div class="arrow" v-if="'permalink' === sortColumn" v-bind:class="[ascending ? 'arrow-up' : 'arrow-down']"></div>
					</th>
					<th v-on:click="sortTable('target_url')">
						Target
						<div class="arrow" v-if="'target_url' === sortColumn" v-bind:class="[ascending ? 'arrow-up' : 'arrow-down']"></div>
					</th>
					<th v-on:click="sortTable('hits')">
						Hits
						<div class="arrow" v-if="'hits' === sortColumn" v-bind:class="[ascending ? 'arrow-up' : 'arrow-down']"></div>
					</th>
					<th v-on:click="sortTable('date')">
						Publish date
						<div class="arrow" v-if="'date' === sortColumn" v-bind:class="[ascending ? 'arrow-up' : 'arrow-down']"></div>
					</th>
				</tr>
				</thead>
				<tbody>
					<tr v-for="row of rows">
						<th>{{row.id}}</th>
						<td>{{row.title}}</td>
						<td>
							<a :href="row.permalink">{{row.permalink}}</a>
						</td>
						<td>
							<a :href="row.target_url">{{row.target_url}}</a>
						</td>
						<td>{{ row.hits }}</td>
						<td>{{row.date}}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</section>
	<?php wp_footer(); ?>
</body>
</html>
