//index.js  
//获取应用实例  
var app = getApp()
Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    tel:'',
    userinfo:[]
  },
  onLoad: function () {
    console.log('onLoad')
    var that = this
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
      url: app.pubData.hostUrl + '/Api/Index/userinfo',
      method: 'post',
      data:{uid:app.pubData.userId},
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var tel = res.data.tel;
        console.log(res.data.userinfo.audit)
        that.setData({
          tel:tel,
          userinfo:res.data.userinfo
        });
      },
    })
  },
  call:function () {
    wx.makePhoneCall({
      phoneNumber: this.data.tel 
    })
  },

  person:function (e) {
    wx.navigateTo({
      url: '../register/register',
    })
  },
})