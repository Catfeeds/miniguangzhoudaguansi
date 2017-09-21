// pages/register/register.js
var app = getApp()
function countdown(that) {
  var second = that.data.second
  if (second == 0) {
    that.setData({
      buttonValue: "获取验证码",
      time: false,
      second: 60
    });
    return;
  }
  var time = setTimeout(function () {
    that.setData({
      second: second - 1
    });
    countdown(that);
  },1000)
}  
Page({

  /**
   * 页面的初始数据
   */
  data: {
    color: "#C5C5C5",
    buttonValue:"获取验证码",
    time:false,
    second:60,
    disabled:true,
    linkTel:''
  },
  phone:function(e) {
    console.log(e)
    var linkTel = e.detail.value;
    if (e.detail.cursor > 10) {
      this.setData({
        color: "#336598",
        disabled: false,
        linkTel: linkTel
      })
    } 
  },
  acquire:function() {
    var that = this;
    var linkTel = this.data.linkTel;
    if (!linkTel || linkTel == "undefined") {
      wx.showToast({
        title: '请输入手机号码!',
      })
      return false;
    }

    var _Url = app.pubData.hostUrl + '/Api/User/get_code';

    countdown(this);
    this.setData({
      buttonValue: "已发送",
      time: true
    });
    wx.request({
      url: _Url,
      method: 'POST',
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      data: {
        tel: linkTel
      },
      success: function (res) {
        if (res.data.status == 1) {
          wx.showModal({
            title: '提示',
            content: '发送验证码成功！',
            showCancel: false
          })
        } else {
          wx.showToast({
            title: res.data.err,
            duration: 2000,
          })
        };
        that.setData({
          buttonValue: "获取验证码",
          time: false,
          second: 60
        });
      },
      fail: function (res) {
        wx.showToast({
          title: '网络异常！',
          duration: 2000,
        })
      },

    });
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
  },
  //点击发送验证码，获取手机号码，往后台发送数据
  setVerify: function (e) {
    var linkTel = this.data.linkTel;
    if (!linkTel || linkTel == "undefined") {
      wx.showToast({
        title: '请输入手机号码!',
      })
      return false;
    }

    var _Url = app.d.ceshiUrl + '/Api/User/get_code';

    var total_micro_second = 60 * 1000;    //表示60秒倒计时，想要变长就把60修改更大
    //验证码倒计时
    count_down(this, total_micro_second);
    this.setData({
      lol: false
    })
    wx.request({
      url: _Url,
      method: 'POST',
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      data: {
        tel: linkTel
      },
      success: function (res) {
        if (res.data.status == 1) {
          wx.showModal({
            title: '提示',
            content: '发送验证码成功！',
            showCancel: false
          })
        } else {
          wx.showToast({
            title: res.data.err,
            duration: 2000,
          })
        }
      },
      fail: function (res) {
        wx.showToast({
          title: '网络异常！',
          duration: 2000,
        })
      },

    });
  },

  //提交
  bindFormSubmit: function (e) {
    var that = this;
    //去除两边空格
    var trim = function (str) {
      return str.replace(/(^\s*)|(\s*$)/g, "");
    };
    // 号码验证
    var reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    console.log(e);
    var fdata = e.detail.value;
    var phone = fdata.phone;
    if (trim(phone).length == 0) {
      wx.showToast({
        icon: 'phone',
        title: '请输入手机号码'
      })
      return false;
    }
    if (!reg.test(trim(phone))) {
      wx.showToast({
        icon: 'phone',
        title: '请输入正确的手机号码'
      })
      return false;
    }

    wx.request({
      url: app.pubData.hostUrl + '/Api/User/user_reg',
      method: 'post',
      data: {
        uid: app.pubData.userId,
        tel: fdata.phone,
        yzcode: fdata.yzcode
      },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        var info = res.data.info;
        if (status == 1) {
          wx.showToast({
            title: '提交成功！',
            duration: 2000
          });
          if (info) {
            if (info.level == 0) {
              setTimeout(function (e) {
                wx.navigateTo({
                  url: '../user/user'
                })
              }, 2300);
              return false;
            } else {
              setTimeout(function (e) {
                wx.navigateTo({
                  url: '../index/index'
                })
              }, 2300);
              return false;
            }
          }

        } else {
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





