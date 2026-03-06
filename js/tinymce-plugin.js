(function() {
	
	// IVAN, LO MIO ESTA ASI:
	// KAREN 

	/*
	tinymce.init({
		// Your options here
		setup: function(editor) {

			// disable toggle button
			 var editorEventCallback = function (eventApi) {
				buttonApi.setDisabled(eventApi.element.nodeName.toLowerCase() === 'time');
			};
			editor.on('NodeChange', editorEventCallback);
			// onSetup should always return the unbind handlers
			return function (buttonApi) {
				editor.off('NodeChange', editorEventCallback);
			};
		}
	})
	*/
	
	// Adds a custom command that later can be executed using execCommand

	tinymce.PluginManager.add( 'customs', function( editor ){

		editor.addButton('font_superscript', {
			icon: false,
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjMuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni42OSA1Ni42OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYuNjkgNTYuNjk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojNDU0OTRDO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjIuNjEsMTAuMjJoNi4wMWwxNC4yNSwzOC4yN2gtNS44M2wtMy45OC0xMS40NkgxNy41M2wtNC4yNSwxMS40Nkg3LjgzTDIyLjYxLDEwLjIyeiBNMzEuMzUsMzIuOEwyNS4zOSwxNS45CgkJTDE5LjA2LDMyLjhIMzEuMzV6Ii8+CjwvZz4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNDUuMjgsNi43OGMtMC4zNi0wLjQzLTAuODgtMC42NS0xLjU1LTAuNjVjLTAuOTIsMC0xLjU1LDAuMzQtMS44OCwxLjAzYy0wLjE5LDAuNC0wLjMxLDEuMDMtMC4zNCwxLjloLTIuOTUKCQljMC4wNS0xLjMxLDAuMjktMi4zNywwLjcxLTMuMThjMC44MS0xLjU0LDIuMjUtMi4zMSw0LjMxLTIuMzFjMS42MywwLDIuOTMsMC40NSwzLjksMS4zNnMxLjQ1LDIuMSwxLjQ1LDMuNTkKCQljMCwxLjE0LTAuMzQsMi4xNi0xLjAyLDMuMDVjLTAuNDUsMC41OS0xLjE4LDEuMjUtMi4yLDEuOTdMNDQuNSwxNC40Yy0wLjc2LDAuNTQtMS4yOCwwLjkzLTEuNTYsMS4xN3MtMC41MiwwLjUyLTAuNzEsMC44NGg2Ljc0CgkJdjIuNjdIMzguMzhjMC4wMy0xLjExLDAuMjctMi4xMiwwLjcxLTMuMDNjMC40My0xLjAzLDEuNDYtMi4xMiwzLjA3LTMuMjdjMS40LTEsMi4zLTEuNzIsMi43Mi0yLjE1YzAuNjMtMC42NywwLjk1LTEuNDEsMC45NS0yLjIxCgkJQzQ1LjgzLDcuNzUsNDUuNjQsNy4yMSw0NS4yOCw2Ljc4eiIvPgo8L2c+Cjwvc3ZnPgo=',
			tooltip: 'Superscript',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_superscript');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_superscript', function(state) {
						btn.active(state);
					});
				});
			}
		});
		editor.addButton('font_subscript', {
			icon: false,
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjMuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni42OSA1Ni42OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYuNjkgNTYuNjk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojNDU0OTRDO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTkuNjEsOS4wN2g2LjAxbDE0LjI1LDM5LjI3aC01LjgzbC0zLjk4LTExLjc2SDE0LjUzbC00LjI1LDExLjc2SDQuODNMMTkuNjEsOS4wN3ogTTI4LjM1LDMyLjI1TDIyLjM5LDE0LjkKCQlsLTYuMzMsMTcuMzVIMjguMzV6Ii8+CjwvZz4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNDkuODYsNDAuMTZjLTAuMzYtMC40My0wLjg4LTAuNjUtMS41NS0wLjY1Yy0wLjkyLDAtMS41NSwwLjM0LTEuODgsMS4wM2MtMC4xOSwwLjQtMC4zMSwxLjAzLTAuMzQsMS45aC0yLjk1CgkJYzAuMDUtMS4zMSwwLjI5LTIuMzcsMC43MS0zLjE4YzAuODEtMS41NCwyLjI1LTIuMzEsNC4zMS0yLjMxYzEuNjMsMCwyLjkzLDAuNDUsMy45LDEuMzZjMC45NywwLjkxLDEuNDUsMi4xLDEuNDUsMy41OQoJCWMwLDEuMTQtMC4zNCwyLjE2LTEuMDIsMy4wNWMtMC40NSwwLjU5LTEuMTgsMS4yNS0yLjIsMS45N2wtMS4yMSwwLjg2Yy0wLjc2LDAuNTQtMS4yOCwwLjkzLTEuNTYsMS4xN3MtMC41MiwwLjUyLTAuNzEsMC44NGg2Ljc0CgkJdjIuNjdINDIuOTZjMC4wMy0xLjExLDAuMjctMi4xMiwwLjcxLTMuMDNjMC40My0xLjAzLDEuNDYtMi4xMiwzLjA3LTMuMjdjMS40LTEsMi4zLTEuNzIsMi43Mi0yLjE1YzAuNjMtMC42NywwLjk1LTEuNDEsMC45NS0yLjIxCgkJQzUwLjQxLDQxLjEzLDUwLjIzLDQwLjU5LDQ5Ljg2LDQwLjE2eiIvPgo8L2c+Cjwvc3ZnPgo=',
			tooltip: 'Subscript',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_subscript');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_subscript', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('font_color_1', {
			icon: false,
			image:'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48cmVjdCB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9IiM2MEEzODQiLz48L3N2Zz4=',
			tooltip: 'Text Color',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_color_1');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_color_1', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('font_color_2', {
			icon: false,
			image: 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48cmVjdCB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9IiM3MjlBRkQiLz48L3N2Zz4=',
			tooltip: 'Text Color',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_color_2');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_color_2', function(state) {
						btn.active(state);
					});
				});
			}
		});
		
		editor.addButton('font_large_block', {
			icon: false,
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjMuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni42OSA1Ni42OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYuNjkgNTYuNjk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojNDU0OTRDO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTguMzYsMTAuMjFoNi4wMWwxNC4yNSwzOC4yN2gtNS44M2wtMy45OC0xMS40NkgxMy4yOEw5LjAzLDQ4LjQ4SDMuNTdMMTguMzYsMTAuMjF6IE0yNy4xLDMyLjhMMjEuMTQsMTUuOQoJCUwxNC44LDMyLjhIMjcuMXoiLz4KPC9nPgo8cmVjdCB4PSI0Mi41NSIgeT0iMTguMSIgY2xhc3M9InN0MCIgd2lkdGg9IjQuNDciIGhlaWdodD0iMTcuNDYiLz4KPHJlY3QgeD0iMzYuMDYiIHk9IjI0LjYiIGNsYXNzPSJzdDAiIHdpZHRoPSIxNy40NiIgaGVpZ2h0PSI0LjQ3Ii8+Cjwvc3ZnPgo=',
			tooltip: 'Large Text (block)',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_large_block');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_large_block', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('font_large', {
			icon: false,
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjMuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni42OSA1Ni42OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYuNjkgNTYuNjk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojNDU0OTRDO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTguMzYsMTAuMjFoNi4wMWwxNC4yNSwzOC4yN2gtNS44M2wtMy45OC0xMS40NkgxMy4yOEw5LjAzLDQ4LjQ4SDMuNTdMMTguMzYsMTAuMjF6IE0yNy4xLDMyLjhMMjEuMTQsMTUuOQoJCUwxNC44LDMyLjhIMjcuMXoiLz4KPC9nPgo8cmVjdCB4PSI0Mi41NSIgeT0iMTguMSIgY2xhc3M9InN0MCIgd2lkdGg9IjQuNDciIGhlaWdodD0iMTcuNDYiLz4KPHJlY3QgeD0iMzYuMDYiIHk9IjI0LjYiIGNsYXNzPSJzdDAiIHdpZHRoPSIxNy40NiIgaGVpZ2h0PSI0LjQ3Ii8+Cjwvc3ZnPgo=',
			tooltip: 'Large Text',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_large');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_large', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('font_medium', {
			icon: false,
			image: 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNTYuNyA1Ni43IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1Ni43IDU2Ljc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBmaWxsPSIjNDU0OTRDIiBkPSJNMTYuNCwxMC4yaDZsMTQuMywzOC4zaC01LjhsLTQtMTEuNUgxMS4zTDcsNDguNUgxLjZMMTYuNCwxMC4yeiBNMjUuMSwzMi44bC02LTE2LjlsLTYuMywxNi45SDI1LjF6Ii8+PHBvbHlnb24gZmlsbD0iIzQ1NDk0QyIgcG9pbnRzPSI1My41LDE5LjYgNDcsMTkuNiA0NywxMy4xIDQyLjUsMTMuMSA0Mi41LDE5LjYgMzYuMSwxOS42IDM2LjEsMjQuMSA0Mi41LDI0LjEgNDIuNSwzMC42IDQ3LDMwLjYgNDcsMjQuMSA1My41LDI0LjEgIi8+PHJlY3QgZmlsbD0iIzQ1NDk0QyIgeD0iMzYuNSIgeT0iMzQuNyIgY2xhc3M9InN0MCIgd2lkdGg9IjE3LjUiIGhlaWdodD0iNC41Ii8+PC9zdmc+',
			tooltip: 'Medium Text',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_medium');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_medium', function(state) {
						btn.active(state);
					});
				});
			}
		});
		
		editor.addButton('font_small', {
			icon: false,
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjMuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni42OSA1Ni42OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYuNjkgNTYuNjk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojNDU0OTRDO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTguMzYsMTAuMjJoNi4wMWwxNC4yNSwzOC4yN2gtNS44M2wtMy45OC0xMS40NkgxMy4yOEw5LjAzLDQ4LjQ4SDMuNTdMMTguMzYsMTAuMjJ6IE0yNy4xLDMyLjhMMjEuMTQsMTUuOQoJCUwxNC44LDMyLjhIMjcuMXoiLz4KPC9nPgo8cmVjdCB4PSIzNi4wNiIgeT0iMjQuNiIgY2xhc3M9InN0MCIgd2lkdGg9IjE3LjQ2IiBoZWlnaHQ9IjQuNDciLz4KPC9zdmc+Cg==',
			tooltip: 'Small Text',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_small');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_small', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('h_line', {
			icon: 'hr',
			tooltip: 'Horizontal Line',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'h_line');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('h_line', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('font_underline', {
			icon: 'underline',
			tooltip: 'Underline',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'font_underline');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('font_underline', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addCommand('customCleanText', function(ui, v) {
			let message = 'Clearing the text will remove all previously applied styles and unnecessary tags.';
			editor.windowManager.confirm(message, function(ok){
				if(ok){
					editor.selection.collapse();//remove prevoius selection
					editor.execCommand('RemoveFormat', false, 'clean_text');//use empty selection RemoveFormat to generate 'undo'
					editor.execCommand('SelectAll', false, 'clean_text');//select al content
					let html = editor.selection.getContent({format: 'html'});//get selection as html
					document.body.insertAdjacentHTML('beforeend','<div id="tmp-735201-2034">'+html+'</div>');//create temp div element
					let tmp = document.getElementById('tmp-735201-2034');
					tmp.querySelectorAll('a').forEach((el)=>{//replace tags <a> with pseudo tags [a]
						let href = el.getAttribute('href');
						let target = el.getAttribute('target');		
						if(!target){
							target = '';
						}				
						el.insertAdjacentHTML('afterend','[a href="'+href+'" target="'+target+'"]'+el.innerHTML+'[/a]');
						el.remove();
					});
					html = String(tmp.innerHTML)//replace another tags with pseudo tags
					.split('<hr />').join('[hr]').split('<ul').join('[ul]<ul')
					.split('</ul>').join('</ul>[/ul]')
					.split('<ol').join('[ol]<ol')
					.split('</ol>').join('</ol>[/ol]')
					.split('<li').join('[li]<li')
					.split('</li>').join('</li>[/li]')
					.split('<p').join('[p]<p')
					.split('</p>').join('</p>[/p]')
					.split('<table').join('[table]<table')
					.split('</table>').join('</table>[/table]')
					.split('<thead').join('[thead]<thead')
					.split('</thead>').join('</thead>[/thead]')
					.split('<tr').join('[tr]<tr')
					.split('</tr>').join('</tr>[/tr]')
					.split('<th').join('[th]<th')
					.split('</th>').join('</th>[/th]')
					.split('<td').join('[td]<td')
					.split('</td>').join('</td>[/td]')
					.split('<tbody').join('[tbody]<tbody')
					.split('</tbody>').join('</tbody>[/tbody]')
					.split('<tfooter').join('[tfooter]<tfooter')
					.split('</tfooter>').join('</tfooter>[/tfooter]')
					.split('<iframe').join('[iframe')
					.split('></iframe>').join('][/iframe]')
					.split('<br>').join('[br]')
					.split('<img ').join('[img ')
					.split(' />').join(' /]')
					.split('"/>').join('"/]')
					.split('&nbsp;').join(' ')
					.replace( /(<([^>]+)>)/ig, '')//remove unnecessary tags
					.split('[p]').join('<p>')//restore tags from pseudo tags
					.split('[/p]').join('</p>')
					.split('[table]').join('<table>')
					.split('[/table]').join('</table>')
					.split('[thead]').join('<thead>')
					.split('[/thead]').join('</thead>')
					.split('[tr]').join('<tr>')
					.split('[/tr]').join('</tr>')
					.split('[th]').join('<th>')
					.split('[/th]').join('</th>')
					.split('[td]').join('<td>')
					.split('[/td]').join('</td>')
					.split('[tbody]').join('<tbody>')
					.split('[/tbody]').join('</tbody>')
					.split('[tfooter]').join('<tfooter>')
					.split('[/tfooter]').join('</tfooter>')
					.split('[br]').join('<br>')
					.split('[ul]').join('<ul>')
					.split('[/ul]').join('</ul>')
					.split('[ol]').join('<ol>')
					.split('[/ol]').join('</ol>')
					.split('[li]').join('<li>')
					.split('[/li]').join('</li>')
					.split('[hr]').join('<hr />')
					.split('[iframe').join('<iframe')
					.split('][/iframe]').join('></iframe>')
					.split('"]').join('">')
					.split('[img ').join('<img ')
					.split(' /]').join(' />')
					.split('"/]').join('"/>')
					.split('[a').join('<a')
					.split('[/a]').join('</a>')
					;
					editor.setContent(html);//apply cleaned content
					tmp.remove();//remove temp div element
				}
			});
		});

		editor.addButton('clean_text', {
			icon: false,
			tooltip: 'Clean Text',
			image: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNHB4IiBoZWlnaHQ9IjI0cHgiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzRBNTA1NSIgZD0iTTE2IDExaC0xVjNjMC0xLjEtLjktMi0yLTJoLTJjLTEuMSAwLTIgLjktMiAydjhIOGMtMi43NiAwLTUgMi4yNC01IDV2N2gxOHYtN2MwLTIuNzYtMi4yNC01LTUtNXptLTUtOGgydjhoLTJWM3ptOCAxOGgtMnYtM2MwLS41NS0uNDUtMS0xLTFzLTEgLjQ1LTEgMXYzaC0ydi0zYzAtLjU1LS40NS0xLTEtMXMtMSAuNDUtMSAxdjNIOXYtM2MwLS41NS0uNDUtMS0xLTFzLTEgLjQ1LTEgMXYzSDV2LTVjMC0xLjY1IDEuMzUtMyAzLTNoOGMxLjY1IDAgMyAxLjM1IDMgM3Y1eiIvPjwvc3ZnPg==',
			text: '',
			onclick: function(e) {
				//editor.execCommand('mceToggleFormat', false, 'clean_text');
				editor.execCommand('customCleanText', false, 'clean_text');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('clean_text', function(state) {
						//btn.active(state);
					});
				});
			}
		});
		
		// KAREN
		editor.addButton('no_wrap_white_space', {
			icon: false,
			tooltip: 'No wrap white space',
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjUuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni43IDU2LjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDU2LjcgNTYuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiM0NTQ5NEM7fQoJLnN0MXtmaWxsOm5vbmU7c3Ryb2tlOiM0NTQ5NEM7c3Ryb2tlLXdpZHRoOjM7c3Ryb2tlLW1pdGVybGltaXQ6MTA7fQoJLnN0MntmaWxsOm5vbmU7c3Ryb2tlOiM0NTQ5NEM7c3Ryb2tlLXdpZHRoOjM7c3Ryb2tlLW1pdGVybGltaXQ6MTA7c3Ryb2tlLWRhc2hhcnJheToyLjg3NDcsMi44NzQ3O30KCS5zdDN7ZmlsbDpub25lO3N0cm9rZTojNDU0OTRDO3N0cm9rZS13aWR0aDozO3N0cm9rZS1taXRlcmxpbWl0OjEwO3N0cm9rZS1kYXNoYXJyYXk6Mi45MDE0LDIuOTAxNDt9Cjwvc3R5bGU+CjxnPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTM2LjcsOS42aDUuOWwxNCwzNy42aC01LjdMNDcsMzUuOUgzMS43bC00LjIsMTEuMmgtNS40TDM2LjcsOS42eiBNNDUuMywzMS43bC01LjktMTYuNmwtNi4yLDE2LjZINDUuM3oiLz4KPC9nPgo8Zz4KCTxnPgoJCTxwb2x5bGluZSBjbGFzcz0ic3QxIiBwb2ludHM9IjQ2LjIsNTAuMSA0Ni4yLDUxLjYgNDQuNyw1MS42IAkJIi8+CgkJPGxpbmUgY2xhc3M9InN0MiIgeDE9IjQxLjkiIHkxPSI1MS42IiB4Mj0iOC44IiB5Mj0iNTEuNiIvPgoJCTxwb2x5bGluZSBjbGFzcz0ic3QxIiBwb2ludHM9IjcuNCw1MS42IDUuOSw1MS42IDUuOSw1MC4xIAkJIi8+CgkJPGxpbmUgY2xhc3M9InN0MyIgeDE9IjUuOSIgeTE9IjQ3LjIiIHgyPSI1LjkiIHkyPSI4Ii8+CgkJPHBvbHlsaW5lIGNsYXNzPSJzdDEiIHBvaW50cz0iNS45LDYuNiA1LjksNS4xIDcuNCw1LjEgCQkiLz4KCQk8bGluZSBjbGFzcz0ic3QyIiB4MT0iMTAuMiIgeTE9IjUuMSIgeDI9IjQzLjMiIHkyPSI1LjEiLz4KCQk8cG9seWxpbmUgY2xhc3M9InN0MSIgcG9pbnRzPSI0NC43LDUuMSA0Ni4yLDUuMSA0Ni4yLDYuNiAJCSIvPgoJCTxsaW5lIGNsYXNzPSJzdDMiIHgxPSI0Ni4yIiB5MT0iOS41IiB4Mj0iNDYuMiIgeTI9IjQ4LjciLz4KCTwvZz4KPC9nPgo8L3N2Zz4K',
			//image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjUuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1Ni43IDU2LjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDU2LjcgNTYuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiM0NTQ5NEM7fQoJLnN0MXtmaWxsOm5vbmU7c3Ryb2tlOiM0NTQ5NEM7c3Ryb2tlLXdpZHRoOjM7c3Ryb2tlLW1pdGVybGltaXQ6MTA7fQoJLnN0MntmaWxsOm5vbmU7c3Ryb2tlOiM0NTQ5NEM7c3Ryb2tlLXdpZHRoOjM7c3Ryb2tlLW1pdGVybGltaXQ6MTA7c3Ryb2tlLWRhc2hhcnJheTozLjAzNDMsMy4wMzQzO30KCS5zdDN7ZmlsbDpub25lO3N0cm9rZTojNDU0OTRDO3N0cm9rZS13aWR0aDozO3N0cm9rZS1taXRlcmxpbWl0OjEwO3N0cm9rZS1kYXNoYXJyYXk6Mi45MDE0LDIuOTAxNDt9Cjwvc3R5bGU+CjxnPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTM2LjcsOS42aDUuOWwxNCwzNy42aC01LjdMNDcsMzUuOUgzMS43bC00LjIsMTEuMmgtNS40TDM2LjcsOS42eiBNNDUuMywzMS43bC01LjktMTYuNmwtNi4yLDE2LjZINDUuM3oiLz4KPC9nPgo8Zz4KCTxnPgoJCTxwb2x5bGluZSBjbGFzcz0ic3QxIiBwb2ludHM9IjQ4LjMsNTAuMSA0OC4zLDUxLjYgNDYuOCw1MS42IAkJIi8+CgkJPGxpbmUgY2xhc3M9InN0MiIgeDE9IjQzLjgiIHkxPSI1MS42IiB4Mj0iOC45IiB5Mj0iNTEuNiIvPgoJCTxwb2x5bGluZSBjbGFzcz0ic3QxIiBwb2ludHM9IjcuNCw1MS42IDUuOSw1MS42IDUuOSw1MC4xIAkJIi8+CgkJPGxpbmUgY2xhc3M9InN0MyIgeDE9IjUuOSIgeTE9IjQ3LjIiIHgyPSI1LjkiIHkyPSI4Ii8+CgkJPHBvbHlsaW5lIGNsYXNzPSJzdDEiIHBvaW50cz0iNS45LDYuNiA1LjksNS4xIDcuNCw1LjEgCQkiLz4KCQk8bGluZSBjbGFzcz0ic3QyIiB4MT0iMTAuNCIgeTE9IjUuMSIgeDI9IjQ1LjMiIHkyPSI1LjEiLz4KCQk8cG9seWxpbmUgY2xhc3M9InN0MSIgcG9pbnRzPSI0Ni44LDUuMSA0OC4zLDUuMSA0OC4zLDYuNiAJCSIvPgoJCTxsaW5lIGNsYXNzPSJzdDMiIHgxPSI0OC4zIiB5MT0iOS41IiB4Mj0iNDguMyIgeTI9IjQ4LjciLz4KCTwvZz4KPC9nPgo8L3N2Zz4K',
			text: '',
			onclick: function() {
				editor.execCommand('mceToggleFormat', false, 'no_wrap_white_space');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('no_wrap_white_space', function(state) {
						btn.active(state);
					});
				});
			}
		});
		
		// END KAREN

		editor.addButton('shortcode_circular_button', {
			icon: '',
			tooltip: 'Insert Circular Button',
			image: 'data:image/png;base64,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',
			text: '',
			onclick: function() {
				//alert('hola mundo')
				//editor.execCommand('mceInsertRawHTML', false, "[circular-button url='#' text='Button Text']");
				/* const node = tinyMCE.activeEditor.selection.getNode();
				if(node.nodeName == 'P'){
					editor.execCommand('mceInsertRawHTML', false, "[circular-button url='#' text='Button Text']");
				}else{
					node.parentNode.insertAdjacentHTML('afterend',"[circular-button url='#' text='Button Text']");
					tinymce.activeEditor.undoManager.add();
				} */

				//https://madebydenis.com/adding-shortcode-button-to-tinymce-editor/
				editor.windowManager.open( {
                    title: 'Insert Circular Button',
                    body: [
                        {
                            type: 'textbox',
                            name: 'button_text',
                            label: 'Button Text',
                            value: '',
                            classes: 'cir-btninput-button-text',
                        },
                        {
                            type: 'textbox',
                            name: 'button_link',
                            label: 'Button Link',
                            text: '',
                            classes: 'cir-btn-input-button-link',
                        },
						{
                            type: 'checkbox',
                            name: 'open_blank',
                            label: 'Open in New Window',
                            text: '',
                            classes: 'cir-btn-input-open-blank',
                        },
						{
                            type   : 'combobox',
                            name   : 'color',
                            label  : 'Color',
                            values : [
                                { text: 'Indigo', value: 'indigo' },
                                { text: 'Cream', value: 'cream' },
                                { text: 'Orange', value: 'orange' },
								{ text: 'Darkgreen', value: 'darkgreen' },
                                { text: 'Darkgray', value: 'darkgray' },
								{ text: 'White', value: 'white' },
                            ],
                            classes: 'cir-btn-input-color',
                        },
                    ],
                    onsubmit: function( e ) {
						const node = tinyMCE.activeEditor.selection.getNode();
						const link = e.data.button_link || '#';
						const text = e.data.button_text || 'Button';
						const target = e.data.open_blank ? "target='_blank'" : '';
						const color = e.data.color || 'indigo';
						if(node.nodeName == 'P'){
							editor.execCommand('mceInsertRawHTML', false, "[circular-button url='"+link+"' text='"+text+"' "+target+" color='"+color+"']");
						}else{
							node.parentNode.insertAdjacentHTML('afterend',"[circular-button url='"+link+"' text='"+text+"' "+target+" color='"+color+"']");
							tinymce.activeEditor.undoManager.add();
						}
						//editor.insertContent( "[circular-button url='"+e.data.button_link+"' text='"+e.data.button_text+"']");
                        //editor.insertContent( '[shortcode-name img="' + e.data.img + '" list="' + e.data.listbox + '" combo="' + e.data.combobox + '" text="' + e.data.textbox + '" check="' + e.data.checkbox + '" color="' + e.data.colorbox + '" color_2="' + e.data.colorpicker + '" radio="' + e.data.radio + '"]');
                    }
                });
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('shortcode_circular_button', function(state) {
						btn.active(state);
					});
				});
			}
		});

		editor.addButton('list_no_bullets', {
			icon: '',
			tooltip: 'Add/remove bulletpoints from list',
			image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAACXBIWXMAABYlAAAWJQFJUiTwAAACnklEQVRYhe2Y32tSYRjHv2fr3IUplGR/yDAmMhAvvMg2nc4UlU4XdiIIuupmXbT/weGNMWO2TtOom8Qx+7FE8CKiIqKuc8SCLHa31tNFunU8r+5154fB9oUX9PVVP359nx88AhHhf9bYqAEO0jGgXh0JwCwA6qysAZ+nkqAzil0AWjOxNADg0coSAAj6sfZ1gvdgLl+gjXoDRIDX40ZGSgsA5otKyUgejbgAc/kCVarre88r1RpO2WwUm53Bw/ITAEAkFASAxZEAbtQbmr2zzjPodU8pP5bvK2X5MCDj42NYXb6ruR5cQdJ7TR12O6a8HpV7DocdlWrtMGwDxeWg1+NWfXkkHNS4F/D7FgJ+321j8TgBM1JaEEWR6o0mbLaTCPh96EZuJBREPBpehAn3jxsQAKRkXJCScQC4U1RK8z0vfwOwaSRYV8MmaheA0/9uxKNhwCT3gOEB5aJSkhmpxRT3gOEA+7m3YCRQr7jv4Os3b1sfP31mJWbT3AM4HczlC/R1a0u1Z4V7AKeD795/QEZKqVLL85evMOX1bALAbOIy7e7+1gWiq5JcvBDQJOaf29u6gHjF026pWqpuWWu3f+BSJGRoa8USz1+saalcTicCfp/pcAAAIhq0XERE03Mpmp5L0fKDVSKibGf/oPcasg66gzKjITWtrLE0CNDyssbSIEDLyxpL/QCZ7l2/eUtOSDLl8kuWzUv6RbHGvadr6/jS+mtepVqDKIokJeMjSTNM96SrN1SH6o0mOv2h5ZVE497asxf43m6rDlk1FWM5qHHv3oqiOTR5fmLvMeuXGyUWoCZyk7HotZ2dX1RvNEFEmHRP4EoqYUklYdVi6hllnIPFqUVNoy0vWdpX1qqS1m/pHR6ZriMxHzRVx4B69QfBcOUPKHLx5AAAAABJRU5ErkJggg==',
			text: '',
			onclick: function(evt) {
				//console.log(evt)
				const node = tinyMCE.activeEditor.selection.getNode();
				if(node.nodeName == 'UL'){
					node.classList.toggle('no-bullet-points');
				}
				if(node.nodeName == 'LI'){
					node.parentNode.classList.toggle('no-bullet-points');
				}
				tinymce.activeEditor.undoManager.add();
				//editor.execCommand('mceToggleFormat', false, 'list_no_bullets');
			},
			onpostrender: function() {
				var btn = this;
				editor.on('init', function() {
					editor.formatter.formatChanged('list_no_bullets', function(state) {
						btn.active(state);
					});
				});
			}
		});

		let $mediaButton = document.querySelector('#wp-'+editor.id+'-media-buttons button.insert-media');
		if(!!$mediaButton){
			editor.addButton('add_media_custom', {
				icon: 'image',
				tooltip: 'Add Media',
				text: 'Add Media',
				classes: 'custom-media-button',
				onclick: function() {
					let $mediaButton = document.querySelector('#wp-'+editor.id+'-media-buttons button.insert-media');
					$mediaButton.click();
				},
				onpostrender: function() {
					var btn = this;
					editor.on('init', function() {
						editor.formatter.formatChanged('add_media_custom', function(state) {
							btn.active(state);
						});
					});
				}
			});
		}

		editor.on("init", function(){
			editor.addShortcut("ctrl+u", "", function(){
				editor.execCommand('mceToggleFormat', false, 'font_underline');
			});
			editor.addShortcut("meta+u", "", function(){
				editor.execCommand('mceToggleFormat', false, 'font_underline');
			});
			let $mediaButton = document.querySelector('#wp-'+editor.id+'-media-buttons button.insert-media');
			if(!!$mediaButton){
				$mediaButton.style.display = 'none';
			}
		});
		
	});
})();