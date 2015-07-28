var PopupPanel = function() {
	var indentifier = Math.random()*1000;
	this.$panel_ = $([
									 '<div id="p_'+indentifier+'" class="popupPanel_">',
									 '<span class="title_"></span>',
									 '<span class="close_">×</span>',
									 '<div class="content_"></div>',
									 '</div>'].join(''));
};
PopupPanel.prototype = {
	render: function(closeCallback) {
		this.$panel_.css('display', 'none').appendTo('body');
		var self_ = this;
		var $close = this.$panel_.find('.close_');
		$close.click(function() {
			self_.show(false, function($panel_, self_) {
				if(closeCallback) closeCallback.call(self_, $panel_, self_);
			});
		});
		$close.hover(function() {
			$(this).addClass('closeHover_');
		}, function() {
			$(this).removeClass('closeHover_');
		});

		return this;
	},
	show: function(b, cb) {
		(b == true && this.$panel_.show()) || this.$panel_.hide();
		if(cb) cb.call(this, this.$panel_, this);
		return this;
	},
	setTitle: function(title) {
		this.$panel_.find('.title_').text(title);
		return this;
	},
	setContent: function(content) {
		this.$panel_.find('.content_').html(content);
		return this;
	},
	setPosition: function($trigger) {
		var tp = {
			l: $trigger.offset().left,
			t: $trigger.offset().top,
			w: $trigger.width(),
			h: $trigger.height()
		};
		this.$panel_.offset({left: tp.l, top: tp.t});
		return this;
	},
	isShowed: function() {
		return this.$panel_.css('display') == 'block';
	}
};
