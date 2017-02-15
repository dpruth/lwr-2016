/* =============================================================================
~~ ISOTOPE JS
~~ A prototype used to create a flexible isotope grid.
==============================================================================*/
var IsotopeGrid = function(obj) {
    if (typeof obj == 'object') {
        this.target = jQuery(obj.target);
        this.items = {
            target : jQuery('[data-isotope-container]', obj.target),
            all : jQuery('[data-isotope-item]', obj.target),
            active : jQuery('[data-isotope-item]', obj.target),
        };
        this.functionality = {
            search : {
                status : (jQuery('[data-isotope-search]', obj.target).length) ? true : false,
                target : jQuery('[data-isotope-search]', obj.target),
                submit : jQuery('[data-isotope-submit]', obj.target),
                clear : jQuery('[data-isotope-search-clear]', obj.target),
                term : '',
            },
            filter : {
                status : (jQuery('[data-isotope-filter]', obj.target).length) ? true : false,
                target : jQuery('[data-isotope-filter]', obj.target),
                junction : (obj.filter_junction) ? (obj.filter_junction == 'AND') ? 'AND' : 'OR' : 'OR',
                active : [],
            },
            sorting : {
                status : (jQuery('[data-isotope-sort]', obj.target).length) ? true : false,
                target : jQuery('[data-isotope-sort]', obj.target),
                method : null,
                active : [],
            },
        };
        this.afterwards = obj.afterwards;
        this.init();
    } else {
        console.warn('You did not supply a valid arguement. Please correct and try again.');
    }
};
jQuery(function() {
    if (typeof String.prototype.trim !== 'function') {
        String.prototype.trim = function() {
            return this.replace(/^\s+|\s+jQuery/g, '');
        }
    }
    IsotopeGrid.prototype.init = function() {
        this.reformat();
        this.prepareSorting();
    };
    /* =============================================================================
    ~~ ISOTOPE SETUP
    ~~ Gathering all positions and adjusting the items to create the isotope.
    ==============================================================================*/
    IsotopeGrid.prototype.reformat = function() {
        var self = this,
            isotope_width = this.items.target.outerWidth(),
            items = this.items.active,
            items_across = (isotope_width / jQuery(items[0]).outerWidth(true)).toFixed(0),
            current_top = 0,
            new_heights = 0,
            current_width = 0;
        jQuery(items).css('position', 'absolute');
        jQuery('[data-isotope-counter]').text(items.length);
        if (items.length) {
            jQuery('[data-isotope-placeholder]', this.items.target).fadeOut();
            jQuery.each(items, function(i, v) {
                var item_width = jQuery(v).outerWidth(true),
                    item_height = jQuery(v).outerHeight(true);
                (i && (i % items_across === 0)) ? current_width = 0 : null;
                (i >= items_across) ? current_top = parseFloat(jQuery(items[i - items_across]).attr('data-position-top')) + parseFloat(jQuery(items[i - items_across]).attr('data-item-height')) : null;
                jQuery(v).attr('data-position-top', current_top).attr('data-position-left', current_width).attr('data-item-height', item_height).css({
                    '-webkit-transform': 'translate(' + current_width + 'px,' + current_top + 'px)',
                    '-moz-transform': 'translate(' + current_width + 'px,' + current_top + 'px)',
                    '-ms-transform': 'translate(' + current_width + 'px,' + current_top + 'px)',
                    'transform': 'translate(' + current_width + 'px,' + current_top + 'px)'
                });
                current_width = current_width + item_width;
                ((current_top + item_height) > new_heights) ? new_heights = current_top + item_height : null;
            });
        } else {
            jQuery('[data-isotope-placeholder]', this.items.target).fadeIn();
        }
        jQuery(this.items.target).css('height', new_heights);
    };
    IsotopeGrid.prototype.prepareSorting = function() {
        var target = this.items.all;
        jQuery.each(target, function(i, v) {
            jQuery(v).attr('data-date-sort', Date.parse(jQuery(v).attr('data-date-sort')));
        });
        this.bindInteractions();
    };
    /* =============================================================================
    ~~ BIND ISOTOPE ACTIONS
    ~~ Bind all event hanlders to the filters.
    ==============================================================================*/
    IsotopeGrid.prototype.bindInteractions = function() {
        var self = this;
        jQuery.each(this.functionality.filter.target, function(i, v) {
            var filter_binding = (jQuery(v).is('select')) ? 'change' : 'click touch';
            jQuery(v).unbind('click touch change').bind(filter_binding, function() {
                var value = (jQuery(this).is('select')) ? jQuery(this).val() : jQuery(this).attr('data-isotope-filter'),
                    index = self.functionality.filter.active.indexOf(value);
                if (jQuery(this).hasClass('active') && jQuery(this).is('select')) {
                    var prev_index = self.functionality.filter.active.indexOf(jQuery(this).attr('data-previous-filter'));
                    (prev_index >= 0) ? self.functionality.filter.active.splice(prev_index, 1) : null;
                }
                if (index > -1) {
                    jQuery(this).removeClass('active');
                    self.functionality.filter.active.splice(index, 1);
                } else {
                    jQuery(this).addClass('active');
                    (jQuery(this).is('select')) ? jQuery(this).attr('data-previous-filter', value) : null;
                    (value !== "") ? self.functionality.filter.active.push(value) : null;
                }
                self.filterItems();
            });
        });
        jQuery.each(this.functionality.sorting.target, function(i, v) {
            var sort_binding = (jQuery(v).is('select')) ? 'change' : 'click touch';
            jQuery(v).unbind('click touch change').bind(sort_binding, function() {
                jQuery(self.functionality.sorting.target).removeClass('active');
                jQuery(v).addClass('active');
                self.functionality.sorting.method = jQuery(this).attr('data-isotope-sort');
                var value = (jQuery(this).is('select')) ? jQuery(this).val() : jQuery(this).attr('data-isotope-order');
                self.functionality.sorting.active = (value !== "") ? value : "";
                self.sortItems();
            });
        });
        jQuery(this.functionality.search.target).on('change', function() {
            var value = jQuery(this).val();
            self.functionality.search.term = value.replace(/<[^>]*>?/ig,"");
            jQuery(this).val(self.functionality.search.term);
            jQuery('[data-isotope-search-result] [data-term]').text(self.functionality.search.term);
            self.functionality.search.term = self.functionality.search.term.toLowerCase();
            (!self.functionality.search.submit.length) ? self.searchItems() : null;
        });
        if (self.functionality.search.submit.length) {
            jQuery(this.functionality.search.submit).on('click touch', function(e) {
                e.preventDefault();
                self.searchItems();
            });
        }
        jQuery(this.functionality.search.clear).on('click touch', function() {
            self.functionality.search.term = "";
            jQuery(self.functionality.search.target).val('');
            self.searchItems();
        });
        var time_triggered,
            timeout = false,
            delta = 750,
            resizeend = function() {
                if (new Date() - time_triggered < delta) {
                    setTimeout(resizeend, delta);
                } else {
                    timeout = false;
                    self.reformat();
                }
            };
        jQuery(window).resize(function() {
            time_triggered = new Date();
            if (timeout == false) {
                timeout = true;
                setTimeout(resizeend, delta);
            }
        });
    };
    /* =============================================================================
    ~~ ADJUST FILTERED ITEMS
    ~~ Adjust the items whether using a filtering system or not.
    ==============================================================================*/
    IsotopeGrid.prototype.filterItems = function() {
        var self = this,
            items = self.items.all;
        this.items.active = [];
        jQuery.each(items, function(i, v) {
            if (self.functionality.filter.active.length) {
                var filters = jQuery(v).attr('data-item-filter').split(",");
                for (i = 0; i < filters.length; i++) {
                    filters[i] = filters[i].trim();
                }
                jQuery(v).addClass('no-match');
                var match = (self.functionality.filter.junction == 'AND') ? true : false;
                for (i = 0; i < self.functionality.filter.active.length; i++) {
                    if (self.functionality.filter.junction == 'AND') {
                        (filters.indexOf(self.functionality.filter.active[i]) == -1) ? match = false : null;
                    } else {
                        (filters.indexOf(self.functionality.filter.active[i]) > -1) ? match = true : null;
                    }
                }
                (match) ? (jQuery(v).hasClass('no-match')) ? self.items.active.push(jQuery(v).removeClass('no-match')) : null : null;
            } else {
                self.items.active.push(jQuery(v).removeClass('no-match'));
            }
        });
        (this.functionality.search.term) ? this.searchItems() : this.setNewPositions();
    };
    /* =============================================================================
    ~~ ADJUST SORTED ITEMS
    ~~ Adjust the items whether using a filtering system or not.
    ==============================================================================*/
    IsotopeGrid.prototype.sortItems = function() {
        var self = this,
            sort_by = (self.functionality.sorting.method == "date") ? "data-date-sort" : "data-number-sort",
            items = (self.items.active.length) ? self.items.active : self.items.all;
            rearrange = function(a,b) {
                if (self.functionality.sorting.active == "DESC") {
                    if (Number(jQuery(a).attr(sort_by)) > Number(jQuery(b).attr(sort_by))) {
                        return -1;
                    }
                    if (Number(jQuery(a).attr(sort_by)) < Number(jQuery(b).attr(sort_by))) {
                        return 1;
                    }
                } else {
                    if (Number(jQuery(a).attr(sort_by)) < Number(jQuery(b).attr(sort_by))) {
                        return -1;
                    }
                    if (Number(jQuery(a).attr(sort_by)) > Number(jQuery(b).attr(sort_by))) {
                        return 1;
                    }
                }
                return 0;
            };
        items.sort(rearrange);
        this.items.active = items;
        (this.functionality.search.term) ? this.searchItems() : this.setNewPositions();
    };
    /* =============================================================================
    ~~ SEARCH THROUGH ITEMS
    ~~ Adjust the items whether using a filtering system or not.
    ==============================================================================*/
    IsotopeGrid.prototype.searchItems = function() {
        var self = this,
            items = (self.items.active.length) ? self.items.active : self.items.all;
        this.items.active = [];
        jQuery.each(items, function(i, v) {
            if (self.functionality.search.term) {
                var context = jQuery(v).text().toLowerCase();
                if (context.indexOf(self.functionality.search.term) > -1) {
                    (jQuery(v).hasClass('no-match')) ? self.items.active.push(jQuery(v).removeClass('no-match')) : self.items.active.push(v);
                } else {
                    jQuery(v).addClass('no-match');
                }
            } else {
                self.items.active.push(jQuery(v).removeClass('no-match'));
                self.filterItems();
                self.sortItems();
            }
        });
        if (self.functionality.search.term) {
            jQuery('[data-isotope-search-result] [data-count]').text(self.items.active.length);
            jQuery('[data-isotope-search-result]').fadeIn();
        } else {
            jQuery('[data-isotope-search-result]').fadeOut();
        }
        this.setNewPositions();
    };
    /* =============================================================================
    ~~ ADJUST POSITIONS OF ALL ITEMS
    ~~ Adjust the items whether using a filtering system or not.
    ==============================================================================*/
    IsotopeGrid.prototype.setNewPositions = function() {
        var self = this;
        this.reformat();
        setTimeout(function() {
            (self.afterwards) ? self.afterwards({items : self.items.active, active_filter : self.functionality}) : null;
        }, 300);
    };
});
