"use strict";

var LocalStorage = new (function () {
  this.storageSpace = "";
  this.data = [];

  this.init = function (localStorageSpage) {
    this.storageSpace = localStorageSpage;
  };

  this.store = function () {
    localStorage.setItem(this.storageSpace, JSON.stringify(this.data));
  };

  this.getAll = function () {
    var localStorageData = JSON.parse(localStorage.getItem(this.storageSpace));
    if (localStorageData !== null) {
      this.data = localStorageData;
    }
    return this.data;
  };

  this.add = function (host) {
    var id = 0;
    if (this.data.length > 0) {
      $.each(this.data, function (index, item) {
        if (id < item.id) {
          id = item.id;
        }
      });
    }
    var item = {
      id: id + 1,
      host: host,
    };
    this.data.push(item);
    this.store();

    return item;
  };

  this.remove = function (id) {
    var indexItem = -1;
    $.each(this.data, function (index, item) {
      if (id === item.id) {
        indexItem = index;
        return false; //break
      }
    });
    if (indexItem > -1 && indexItem < this.data.length) {
      this.data.splice(indexItem, 1);
      this.store();
    }
  };
})();

$(document).ready(function () {
  LocalStorage.init("PingIt");
  var items = LocalStorage.getAll();

  $.each(items, function (index, item) {
    loadElement(item, "");
    // $.ajax({
    //   url: "/api/v1/ping?host=" + item.host,
    //   dataType: "json",
    //   success: function (data) {
    //     loadElement(item, data.online);
    //   },
    // });
  });

  $("#host-form").submit(function (event) {
    event.preventDefault();
    $.ajax({
      url: "/api/v1/ping?host=" + $("#inputHost").val(),
      dataType: "json",
      success: function (data) {
        var item = LocalStorage.add(data.host);
        loadElement(item, data.online);
        $("#inputHost").val("");
      },
    });
  });

  $(document).on("click", ".remove", function (e) {
    e.preventDefault();

    if (confirm("Remove host?")) {
      var parent = $(this).parents(".list-group-item");

      LocalStorage.remove(parent.data("item-id"));
      parent.remove();
    }
  });

  $(document).on("click", ".btn-reping", function (e) {
    e.preventDefault();
    var parent = $(this).parents(".list-group-item");
    $.ajax({
      url: "/api/v1/ping?host=" + parent.find("a").text(),
      dataType: "json",
      success: function (data) {
        var status = data.online
          ? "list-group-item-success"
          : "list-group-item-danger";
        parent.removeClass("list-group-item-success");
        parent.removeClass("list-group-item-danger");
        parent.addClass(status);
      },
    });
  });

  function loadElement(item, isOnline) {
    var parentPanel = $("body").find(".list-group");
    if (typeof isOnline === "boolean") {
      var status = isOnline
        ? "list-group-item-success"
        : "list-group-item-danger";
    } else {
      var status = "";
    }

    var element =
      '<li data-item-id="' +
      item.id +
      '" class="list-group-item  d-flex justify-content-between list-group-item ' +
      status +
      '">\n' +
      '<p class="p-0 m-0 flex-grow-1"><a target="_blank" href="http://' +
      item.host +
      '">' +
      item.host +
      "</a></p>\n" +
      '<button class="btn-primary  btn-ping btn-reping">ping</button>\n' +
      '<button class="btn-danger remove">\n' +
      '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">\n' +
      '<path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"></path>\n' +
      "</svg>\n" +
      "</button>\n" +
      "</li>";

    parentPanel.append(element);
  }
});
