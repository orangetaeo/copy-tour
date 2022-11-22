		(function() {
		  'use strict';
		  // Javascript Example
		  // ------------------

		  // Initializing the board.
		  var sortlist = document.getElementById('sortlist');
		  var sb = new Sortboard(sortlist, {
			gutter: 10,
			filterComplete: function(e) {
			  console.log(e);
			},
			sortComplete: function() {
			  console.log('Sort is completed.');
			}
		  });

		  // Filtering
		  var i, filter,
			links = $('#filters a');

		  // Click link event callback
		  function clickCallback() {
			return function() {
			  if (this.className !== 'active') {
				resetActiveLinks();

				// Retrieve the filter value
				filter = this.getAttribute('data-filter');

				// Filtering by retrieved value
				sb.filterBy(filter);

				// Set active class for current link
				this.className = 'active';

				// Set filter class for sortlist
				sortlist.className = (filter === 'all') ? '': 'filtered';
			  }
			};
		  }

		  // Reset active link classes
		  function resetActiveLinks() {
			for (var i = 0; i < links.length; ++i) {
			  links[i].className = '';
			}
		  }

		  // Click event handler for each filter link
		  for (i = 0; i < links.length; ++i) {
			links[i].addEventListener('click', clickCallback(), false);
		  }

		  // Default trigger for first filter link
		  clickCallback().apply(links[0], []);

		})(this);
