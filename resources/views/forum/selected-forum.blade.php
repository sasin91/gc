	<div class="panel panel-default panel-flush">
		<!-- Default panel contents -->
		<div class="panel-heading">@{{ selectedForum.title }}</div>
		<div class="panel-body">
			<span v-if="selectedForum.threads.length === 0" class="alert alert-info">
				Hm, no threads found.
			</span>
			<!-- Table -->
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Author</th>
						<th>Title</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<tr v-else v-for="thread in selectedForum.threads"
						@click="redirectToThread(thread)"
						class="clickable"
					>
						<td>
							@{{ thread.author.name }}
						</td>
						<td>
							@{{ thread.title }}
						</td>
						<td>
							@{{ thread.description }}
						</td>
					</tr>
				</tbody>
			</table>
		</div>	
	</div>