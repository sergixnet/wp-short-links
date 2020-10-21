(function () {
	new Vue({
		el: '#app',
		created: function () {
			this.fetchRows();
		},
		data: function () {
			return {
				ascending: false,
				sortColumn: '',
				rows: [],
			};
		},
		methods: {
			fetchRows: function () {
				fetch('/wp-json/sl/v1/shortlinks/')
					.then((response) => response.json())
					.then((data) => {
						this.rows = data;
					});
			},
			sortTable: function sortTable(col) {
				if (this.sortColumn === col) {
					this.ascending = !this.ascending;
				} else {
					this.ascending = true;
					this.sortColumn = col;
				}

				var ascending = this.ascending;

				this.rows.sort(function (a, b) {
					if (a[col] > b[col]) {
						return ascending ? 1 : -1;
					} else if (a[col] < b[col]) {
						return ascending ? -1 : 1;
					}
					return 0;
				});
			},
		},
	});
})();
