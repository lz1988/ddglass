function CustomizedUploadButton(config) {
	this.config = config;
	this.inputId = 'f_'+Math.round(Math.random()*10000, 10)+1;
	this.init();
}
CustomizedUploadButton.prototype = {
	init: function() {
		var that = this;
		this.text = this.config.text;
		this.button = $(
				'<div class="upload_button">'+
				this.text+
				'<input type="file" id="'+this.inputId+'" name="'+this.config.name+'"/>'+
				'</div>');
		return this;
	},
	show: function() {
		var that = this;
		this.button.appendTo(this.config.appendTo).show();
		this.imgUploader = new FileUploader({
			id: that.inputId,
			action: that.config.action || '',
			method: that.config.method || 'post',
			type: that.config.type || 'json',
			onComplete: that.config.onComplete,
			loading: that.config.loading,
			onChange: that.config.onChange
		});
		return this;
	},
	hide: function() {
		this.button.hide();
		return this;
	},
	remove: function() {
		this.button.remove();
		return this;
	},
	get: function() {
		return this.button; 
	}
}
