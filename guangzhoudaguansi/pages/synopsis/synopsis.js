// pages/synopsis/synopsis.js
var app = getApp();
//引入这个插件，使html内容自动转换成wxml内容
var WxParse = require('../../wxParse/wxParse.js');
Page({
  data:{
    shopInfo:{},
    content:'',
    shopId:0,
    title:'',
    tel:[]
  },

  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    var that = this;
    var shopId = options.shopId;
    var that = this;
    that.setData({
      shopId:shopId
    });
    wx.request({
      url: app.pubData.hostUrl + '/Api/Shangchang/shop_details',
      method: 'post',
      data: { shop_id: shopId},
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if(status==1){
          var content = res.data.content;
          var tel = res.data.tel;
          WxParse.wxParse('content', 'html', content, that, 3);
          that.setData({
            text: res.data.content
          });
          var shopInfo = res.data.shop_info;
          if(shopInfo){
            var title = shopInfo.name;
          }else{
            var title = '优质企业';
          }
          //that.initProductData(data);
          that.setData({
            shopInfo: shopInfo,
            title:title,
            tel:tel,
          });
        }else{
          wx.showToast({
            title: res.data.err,
            duration: 2000
          });
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
  onReady:function(){
    // 页面渲染完成
  },
  onShow:function(){
    // 页面显示
  },
  onHide:function(){
    // 页面隐藏
  },
  onUnload:function(){
    // 页面关闭
  },
  //分享
  onShareAppMessage: function () {
    var title = this.data.title;
    var shopId = this.data.shopId;
    return {
      title: title,
      path: '/pages/synopsis/synopsis?shopId=' + shopId,
      success: function (res) {
        // 分享成功
      },
      fail: function (res) {
        // 分享失败
      }
    }
  }
})