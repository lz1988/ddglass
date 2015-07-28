function FileUploader(config) {
	this.config = config;
	this.input = $('#'+this.config.id);
	this.action = this.config.action || '';
	this.method = this.config.method || 'post';
	this.type = this.config.type || 'json';
	this.init();
}
FileUploader.prototype = {
	init: function() {
		var that = this;
		this.addListener('change', function() {
			if(that.config.onChange) {
				var res = false;
				res = that.config.onChange.call(this, that.getFile(), that.input);
				if(!res) return false;
			}
			that.load();
		});
	},
	load: function() {
		var that = this;
		this.wrap();
		this.send();
		if(that.config.loading) that.config.loading.call(that);
		$('iframe').bind('load', function() {
			var data = that.getResponse(document.getElementById("hidden_frame")).find('body').html();
			data = data.replace(/<pre.*>(.*)<\/pre>/, "$1");
			if(that.config.onComplete) {
				if(that.type == 'json') data = eval('('+data+')');
				that.config.onComplete.call(this, data, that.input);
			}
			// this.input.unwrap();
			$(this).remove();
		});
	},
	getResponse: function(iframe) {
		var doc = $(iframe).contents();
		return doc;
	},
	remove: function() {
		this.input.remove();
	},
	getFile: function() {
		var fileInfo = {};
		var isIE = !!window.ActiveXObject; 
		var isIE6 = isIE&&!window.XMLHttpRequest;
		var isIE8 = isIE&&!!document.documentMode;
		var isIE7 = isIE&&!isIE6&&!isIE8;
		var path = '';
		if(isIE) {
			path = document.getElementById(this.config.id).value;
			fileInfo.fileName = path.slice(path.lastIndexOf('\\')+1);
		} else fileInfo.fileName = document.getElementById(this.config.id).files[0].name;
		return fileInfo;
	},
	send: function(cb) {
		var that = this;
		this.input.parent('form').submit();
	},
	wrap: function() {
		this.input.wrap(
				'<form enctype="multipart/form-data"'+
					'action="'+this.action+'" method="'+this.method+'" target="hidden_frame">'+
				'</form>'
		);
		this.input.parent('form').after(
				'<iframe name="hidden_frame" id="hidden_frame" src="javascript:false;" style="display:none"></iframe>'
		);
	},
	addListener: function(type, cb) {
		if(type == 'change') this.input.bind('change', cb);
	}
};
