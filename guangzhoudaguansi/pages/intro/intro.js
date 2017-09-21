//index.js  
//获取应用实例  
var app = getApp()
Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    number:"10086",
    ls_id:0,
    intro:''
  },
  dial:function () {
    var that = this;
    wx.makePhoneCall({
      phoneNumber: that.data.number
    })
  },
  shouye:function() {
    wx.switchTab({
      url: '../index/index',
      success: function (e) {
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        page.onLoad();
      }
    }) 
  },
  onLoad: function (options) {
    var that = this;
    var ls_id = options.ls_id;
    that.setData({
      ls_id: ls_id
    })
    //调用应用实例的方法获取全局数据  
    app.getUserInfo(function (userInfo) {
      //更新数据  
      that.setData({
        userInfo: userInfo
      })
    })
  },
  onShow:function () {
    var that = this;
    wx.request({
      url: app.pubData.hostUrl + '/Api/Product/details',
      method: 'post',
      data: { ls_id: that.data.ls_id },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if (status == 1) {
          that.setData({
            intro:res.data.info
          });
          wx.setNavigationBarTitle({
            title: res.data.info.name
          })
        }else{
          wx.showToast({
            title: res.data.err,
            duration:2000
          })
        }
        
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          duration: 2000
        });
      },
    })
  },
})  