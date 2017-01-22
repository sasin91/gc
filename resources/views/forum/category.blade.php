<forum-category :category="category" inline-template>
	<div class="panel panel-default panel-flush">
		<!-- Default panel contents -->
		<div class="panel-heading">@{{ category.title }}</div>
		<div class="panel-body">
			<!-- Table -->
			<table class="table table-striped">
				<thead>
					<tr>
						<td>Author</td>
					</tr>
					<tr>
						<th>Title</th>
					</tr>
					<tr>
						<td>Description</td>
					</tr>
				</thead>
				<tbody>
					<tr v-for="thread in threads" @click="redirectToThread(thread)" class="clickable">
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
</forum-category>