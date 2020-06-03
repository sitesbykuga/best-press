function a2c_pdfmake() {
	let  pdfmake_link = document.getElementById('pdfmake-link')
	
	;

	pdfMake.fonts = {
		Lobster: {
			normal: 'Lobster-Regular.ttf'
		},
		Roboto: {
			normal: 'Roboto-Regular.ttf',
			bold: 'Roboto-Bold.ttf',
			italics: 'Roboto-Italic.ttf',
			bolditalics: 'Roboto-BoldItalic.ttf'
		}
	};

	function create_doc(diploma_party_img, diploma_text_after_stamp, diploma_footer) {
		return doc = {
			background: {
				image: diploma_party_img,
				width: 600
			},
			footer: {
				table: {
					headerRows: 0,        			
					body: [
					[ {stack: diploma_text_after_stamp, margin: [ 20, 0, 20, 20 ], style: 'static_text', border: [false, false, false, false]} ],
					[ {stack: diploma_footer, margin: [ 20, 0, 20, 0 ], style: 'footer', border: [false, false, false, false]} ]
					],
					layout: 'noBorders'
				}
			},	
			pageMargins: [ 0, 0, 0, 110 ],	
			styles: {
				static_text: {
					fontSize: 18,
					bold: true,
					alignment: 'center'       				
				},
				dinamic_text_regular: {
					fontSize: 20,
					alignment: 'center',
					color: '#a80000'
				},
				dinamic_text_regular_small: {
					fontSize: 16,
					alignment: 'center',
					color: '#a80000'
				},
				footer: {
					fontSize: 7,
					alignment: 'center'
				},
				dinamic_text_small: {
					fontSize: 18,
					bold: true,
					alignment: 'center'
				}
			}
		}
	};

	function content_doc_ser_uch(app_id, doc, app_status, diploma_text_before_fio, fio, app_edu, diploma_text_before_nomination, nomination){
		let style_name = 'dinamic_text_regular';
		if (app_edu.length > 95) {style_name = 'dinamic_text_regular_small';}

		if (app_status == 'Оценена') {
			doc.content = [
			{ 
				stack: ['№ ' + app_id + '-СУ'], 
				margin: [ 20, 280, 20, 5 ],
				style: 'static_text'
			},
			{ 
				stack: diploma_text_before_fio, 
				margin: [ 10, 5, 20, 10 ],
				style: 'static_text'
			},
			{ 
				text: fio, 
				margin: [ 20, 10, 20, 10 ] ,
				style: 'dinamic_text_regular',
				font: 'Lobster'
			},
			{ 
				text: app_edu, 
				font: 'Lobster',
				style: style_name 
			},
			{ 
				stack: diploma_text_before_nomination, 
				margin: [ 20, 20, 20, 20 ] ,
				style: 'static_text'
			},
			{ 
				text: nomination, 
				margin: [ 20, 10, 20, 10 ] ,
				font: 'Lobster',
				style: 'dinamic_text_regular'
			}
			];
		}
		else {
			doc.content = [
			{ 
				stack: ['№ ' + app_id + '-ДУ'], 
				margin: [ 20, 280, 20, 5 ],
				style: 'static_text'
			},
			{ 
				stack: diploma_text_before_fio, 
				margin: [ 20, 5, 20, 10 ] ,
				style: 'static_text'
			},
			{ 
				text: fio, 
				margin: [ 20, 10, 20, 10 ] ,
				style: 'dinamic_text_regular',
				font: 'Lobster'
			},
			{ 
				text: app_edu, 
				style: style_name,
				font: 'Lobster'
			},
			{ 
				stack: diploma_text_before_nomination, 
				margin: [ 20, 90, 20, 10 ] ,
				style: 'static_text'
			},
			{ 
				text: nomination, 
				margin: [ 20, 10, 20, 10 ] ,
				style: 'dinamic_text_regular',
				font: 'Lobster'
			}
			];
		}
		return doc;
	}

	function content_doc_ser_dir(app_id, doc, app_status, diploma_text_before_fio_dir, diploma_text_before_fio_party, fio, app_edu, diploma_text_before_nomination_dir, nomination, app_post_dir, fio_dir){
		let style_name = 'dinamic_text_regular';
		if (app_edu.length > 95) {style_name = 'dinamic_text_regular_small';}
		let style_name_app_post_dir = 'dinamic_text_regular';
		if (app_post_dir.length > 95) {style_name_app_post_dir = 'dinamic_text_regular_small';}
		if (app_status == 'Оценена') {
			doc.content = [
			{ 
				stack: ['№ ' + app_id + '-СП'], 
				margin: [ 20, 290, 20, 0 ],
				style: 'static_text'
			},
			{ 
				stack: diploma_text_before_fio_dir, 
				margin: [ 20, 5, 20, 5 ] ,
				style: 'static_text'
			},
			{ 
				text: fio_dir, 
				margin: [ 20, 5, 20, 5 ] , 
				style: 'dinamic_text_regular',
				font: 'Lobster'
			},
			{ 
				text: app_post_dir, 
				margin: [ 20, 0, 20, 5 ] , 
				style: style_name_app_post_dir,
				font: 'Lobster'
			},
			{ 
				stack: diploma_text_before_fio_party, 
				margin: [ 20, 5, 20, 5 ] ,
				style: 'static_text'
			},
			{ 
				text: fio, 
				margin: [ 20, 5, 20, 5 ] , 
				style: 'dinamic_text_regular',
				font: 'Lobster'
			},
			{ 
				text: app_edu, 
				margin: [ 20, 0, 20, 5 ] , 
				style: style_name ,
				font: 'Lobster'
			},
			{ 
				stack: diploma_text_before_nomination_dir, 
				margin: [ 20, 5, 20, 5 ] ,
				style: 'static_text'
			},
			{ 
				text: nomination, 
				margin: [ 20, 0, 20, 5 ] , 
				style: 'dinamic_text_regular',
				font: 'Lobster'
			}
			]
		}
		else 
			doc.content = [
		{ 
			stack: ['№ ' + app_id + '-БП'], 
			margin: [ 20, 290, 20, 0 ],
			style: 'static_text'
		},
		{ 
			stack: diploma_text_before_fio_dir, 
			margin: [ 20, 5, 20, 5 ] ,
			style: 'static_text'
		},
		{ 
			text: fio_dir, 
			margin: [ 20, 5, 20, 5 ] , 
			style: 'dinamic_text_regular',
			font: 'Lobster'
		},
		{ 
			text: app_post_dir, 
			margin: [ 20, 0, 20, 5 ] , 
			style: style_name_app_post_dir,
			font: 'Lobster'
		},
		{ 
			stack: diploma_text_before_fio_party, 
			margin: [ 20, 5, 20, 5 ] ,
			style: 'static_text'
		},
		{ 
			text: fio, 
			margin: [ 20, 5, 20, 5 ] , 
			style: 'dinamic_text_regular',
			font: 'Lobster'
		},
		{ 
			text: app_edu, 
			margin: [ 20, 0, 20, 5 ] , 
			style: style_name ,
			font: 'Lobster'
		},
		{ 
			stack: diploma_text_before_nomination_dir, 
			margin: [ 20, 5, 20, 5 ] ,
			style: 'static_text'
		},
		{ 
			text: nomination, 
			margin: [ 20, 0, 20, 5 ] , 
			style: 'dinamic_text_regular',
			font: 'Lobster'
		}
		]
		;
		return doc;
	}


	pdfmake_link.addEventListener('click', function(e) {
		e.preventDefault();

		let  ser_uch_open = document.getElementById('ser_uch_open')
		, ser_uch_download = document.getElementById('ser_uch_download')
		, ser_dir_open = document.getElementById('ser_dir_open')
		, ser_dir_download = document.getElementById('ser_dir_download')
		, diploma_data = document.getElementById('diploma_data')

		, app_id = diploma_data.getAttribute('data-app-id')
		, app_status = diploma_data.getAttribute('data-status')
		, diploma_party_img  = diploma_data.getAttribute('data-img')
		, diploma_text_before_fio = diploma_data.getAttribute('data-text_before_fio').split('<br>')
		, diploma_text_before_nomination = diploma_data.getAttribute('data-text_before_nomination').split('<br>')
		, diploma_text_after_stamp = diploma_data.getAttribute('data-text_after_stamp').split('<br>')
		, diploma_footer = diploma_data.getAttribute('data-footer').split('<br>')
		, diploma_dir_img = diploma_data.getAttribute('data-img_dir').split('<br>')
		, diploma_text_before_fio_dir = diploma_data.getAttribute('data-diploma_text_before_fio_dir').split('<br>')
		, diploma_text_before_fio_party = diploma_data.getAttribute('data-diploma_text_before_fio_party').split('<br>')
		, diploma_text_before_nomination_dir = diploma_data.getAttribute('data-diploma_text_before_nomination_dir').split('<br>')
		, fio = diploma_data.getAttribute('data-fio')
		, nomination = diploma_data.getAttribute('data-nomination')
		, app_edu = diploma_data.getAttribute('data-edu')		
		, app_post_dir = diploma_data.getAttribute('data-post_dir')		
		, fio_dir = diploma_data.getAttribute('data-fio_dir')		
		;

		if (e.target == ser_uch_open) {
			let doc = create_doc(diploma_party_img, diploma_text_after_stamp, diploma_footer);
			doc = content_doc_ser_uch(app_id, doc, app_status, diploma_text_before_fio, fio, app_edu, diploma_text_before_nomination, nomination);		
			pdfMake.createPdf(doc).open();
		}

		if (e.target == ser_uch_download) {
			let doc = create_doc(diploma_party_img, diploma_text_after_stamp, diploma_footer);
			doc = content_doc_ser_uch(app_id, doc, app_status, diploma_text_before_fio, fio, app_edu, diploma_text_before_nomination, nomination);		
			pdfMake.createPdf(doc).download(fio + '.pdf');
		}

		if (e.target == ser_dir_open) {
			let doc = create_doc(diploma_dir_img, diploma_text_after_stamp, diploma_footer);
			doc = content_doc_ser_dir(app_id, doc, app_status, diploma_text_before_fio_dir, diploma_text_before_fio_party, fio, app_edu, diploma_text_before_nomination_dir, nomination, app_post_dir, fio_dir);		
			pdfMake.createPdf(doc).open();
		}

		if (e.target == ser_dir_download) {
			let doc = create_doc(diploma_dir_img, diploma_text_after_stamp, diploma_footer);
			doc = content_doc_ser_dir(app_id, doc, app_status, diploma_text_before_fio_dir, diploma_text_before_fio_party, fio, app_edu, diploma_text_before_nomination_dir, nomination, app_post_dir, fio_dir);		
			pdfMake.createPdf(doc).download(fio_dir + '.pdf');
		}
	});


};

a2c_pdfmake();