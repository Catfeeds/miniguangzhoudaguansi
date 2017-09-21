// pages/reply/reply.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    zi_id:0,
    ls_id:0,
    intro:[],
    reply_content:'',
    reply:'',
    utype:0
  },

  shouye:function () {
    wx.switchTab({
      url: '../index/index',
      success: function (e) {
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        page.onLoad();
      }
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var zi_id = options.zi_id;
    var that = this;
    that.setData({
      zi_id:zi_id
    });
    
    wx.request({
      url: app.pubData.hostUrl + '/Api/Consult/details',
      method: 'post',
      data: { id: zi_id },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if (status == 1) {
          console.log(res.data.info)
          that.setData({
            intro: res.data.info,
            ls_id: res.data.info.ls_id,
            reply_content:res.data.info.reply_content,
            reply: res.data.info.reply_content,
            utype:res.data.info.type
          });
        } else {
          wx.showToast({
            title: res.data.err,
            duration: 2000
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
  //律师解答焦点事件
  bindreply(e) {
    console.log(e.detail.value);
    this.setData({
      reply_content: e.detail.value,
    })
  },

  jieda:function () { 
    var that = this;
    if(that.data.utype==1){
      wx.showToast({
        title: '只有律师才可以解答！',
        duration: 2000
      });
      return false;
    };
    var reply = that.data.reply;
    if(reply!=null && reply!=''){
      wx.showToast({
        title: '已有律师解答！',
        duration:2000
      });
      return false;
    };
    var reply_content = that.data.reply_content;
    if (reply_content == null || reply_content == '') {
      wx.showToast({
        title: '请填写解答内容！',
        duration: 2000
      });
      return false;
    };
    var zi_id = that.data.zi_id;
    var ls_id = that.data.ls_id;
    var reply_content = that.data.reply_content;
    wx.request({
      url: app.pubData.hostUrl + '/Api/Consult/jieda',
      method: 'post',
      data: {
        uid:app.pubData.userId,
        zi_id: zi_id, 
        ls_id: ls_id,
        reply_content: reply_content
        },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if (status == 1) {
          wx.showToast({
            title: res.data.err,
            duration: 2000
          });
          return false;
        } else {
          wx.showToast({
            title: res.data.err,
            duration: 2000
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

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})