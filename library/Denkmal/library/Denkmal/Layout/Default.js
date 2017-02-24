/**
 * @class Denkmal_Layout_Default
 * @extends CM_Layout_Abstract
 */
var Denkmal_Layout_Default = CM_Layout_Abstract.extend({

  /** @type String */
  _class: 'Denkmal_Layout_Default',

  /** @type Object|Null */
  region: null,

  /** @type Number|Null */
  chatActivityStamp: null,

  appEvents: {
    'navigate': function() {
      this._setNavigationIndicationVisible(false);
    }
  },

  childrenEvents: {
    'Denkmal_Page_Events ready': function(view) {
      this._bindContentScroll(view, view.$('.scrollable'));
      this._onContentScroll(view.$('.active .scrollable'));
      this._setWeekMenuVisible(true);
    },

    'Denkmal_Page_Events swipe': function(view) {
      this._onContentScroll(view.$('.active .scrollable'));
    },

    'Denkmal_Page_Events destruct': function(view) {
      this.findChild('Denkmal_Component_HeaderBar').setWeekdayMenuVisible(false);
      this._setWeekMenuVisible(false);
    },

    'Denkmal_Page_Add ready': function(view) {
      this._bindContentScroll(view, $(document));
      this._onContentScroll($(document));
    }
  },

  /**
   * @param {Boolean} state
   */
  _setWeekMenuVisible: function(state) {
    this.findChild('Denkmal_Component_HeaderBar').setWeekdayVisible(state);
  },

  /**
   * @param {CM_View_Abstract} view
   * @param {jQuery} $scrollable
   */
  _bindContentScroll: function(view, $scrollable) {
    var self = this;
    view.bindJquery($scrollable, 'scroll', function(event) {
      self._onContentScroll($(event.currentTarget));
    });
  },

  /**
   * @param {jQuery} $scrollable
   */
  _onContentScroll: function($scrollable) {
    this._setNavigationIndicationVisible($scrollable.scrollTop() <= 20);
  },

  /**
   * @param {Boolean} state
   */
  _setNavigationIndicationVisible: function(state) {
    this.findChild('Denkmal_Component_HeaderBar').setNavigationIndicationVisible(state);
  },

  /**
   * @param {Boolean} state
   */
  _setChatIndication: function(state) {
    this.findChild('Denkmal_Component_HeaderBar').setChatIndication(state);
  },

  /**
   * @param {Number} lastActivityStamp
   */
  _setChatIndicationFromLastActivity: function(lastActivityStamp) {
    var readStamp = cm.storage.get('chatReadStamp');
    if (null == readStamp) {
      readStamp = 0;
    }
    var activityAge = (Math.floor(Date.now() / 1000) - lastActivityStamp);
    this._setChatIndication(lastActivityStamp > readStamp && activityAge < (3600 * 12));
  },

  _updateChatRead: function() {
    var readStamp = Math.floor(Date.now() / 1000);
    cm.storage.set('chatReadStamp', readStamp);
  }
});
