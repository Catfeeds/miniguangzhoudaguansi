// pages/issue/issue.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },
   return: function () {
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
  
  },
  bindFormSubmit: function (e) {
    var fdata = e.detail.value;
    var content = fdata.content;
    var that = this;
    wx.request({
      url: app.pubData.hostUrl + '/Api/Consult/send_consult',
      method: 'post',
      data: {
        ls_id: 0,
        uid: app.pubData.userId,
        dtype: 2,
        content: content
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
          })
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