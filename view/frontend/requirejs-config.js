var config = {
	map: {
		"*": { 
			'lazyloadinginfinitescroll': 'Tutorialstab_LazyloadingInfiniteScroll/js/script',
		}
	},
	shim: {
		'Tutorialstab_LazyloadingInfiniteScroll/js/script': {
			'deps': ['jquery']
		},
		'lazyloadinginfinitescroll': {
			'deps': ['jquery']
		}
	}
};