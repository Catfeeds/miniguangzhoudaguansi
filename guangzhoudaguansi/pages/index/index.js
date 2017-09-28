//获取应用实例
var bmap = require('../budu-map/bmap-wx.min.js');
var app = getApp();
var wxMarkerData = [];

Page({

  /**
   * 页面的初始数据
   */
  data: {
    tap:0,
    tap1:0,
    caseData:false,
    hotData:true,
    zicate:[],
    lslist:[],
    zixun:[],
    fuwu: [],
    legal:[],
    anli:[],
    zpage:1,
    fpage:1
  },
  pageTap:function(e) {
    console.log(e.target.id)
    if(e.target.id == 0) {
      var true_ = true;
      var false_ = false
    } else if (e.target.id == 1) {
      var true_ = false;
      var false_ = true
    }
    this.setData({
      tap:e.target.id,
      hotData: true_,
      caseData: false_
    })
  },
  cunselTap:function(e) {
    this.setData({
      tap1: e.target.id
    })
  },
  //搜索
  sou: function (e) {
    var keyword = this.data.keyword;
    console.log(keyword);
    wx.navigateTo({
      url: '../classify/classify?title=搜索&keyword=' + keyword,
    })
  },

  inputTyping: function (e) {
    var keyword = e.detail.value;
    if (keyword) {
      this.setData({
        keyword: keyword
      });
    }
  },

  //接单
  jie: function (e) {
    var id = e.currentTarget.dataset.id;
    var that = this;
    wx.showModal({
      title: '提示',
      content: '是否确定要接单？',
      success: function (res) {
        res.confirm && wx.request({
          url: app.pubData.hostUrl + '/Api/User/orders',
          method: 'post',
          data: {
            sid: id,
            uid: app.pubData.userId
          },
          header: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          success: function (res) {
            //--init data
            var status = res.data.status;
            if (status == 1) {
              wx.showToast({
                title: '接单成功，请及时联系该会员！',
                duration: 2500
              });
              that.initIndexData();
            } else {
              wx.showToast({
                title: res.data.err,
                duration: 2500
              });
            }
          },
          fail: function () {
            // fail
            wx.showToast({
              title: '网络异常！',
              duration: 2000
            });
          }
        });
      }
    });
  },

  //联系
  lian: function (e) {
    var that = this;
    var userType = app.pubData.userType;
    if (userType < 2) {
      wx.showToast({
        title: '认证律师才可以联系会员！',
        duration: 2000
      });
      return false;
    }
    var id = e.currentTarget.dataset.id;
    var phone = e.currentTarget.dataset.phone;
    wx.makePhoneCall({
      phoneNumber: phone, //此号码并非真实电话号码，仅用于测试
      success: function () {
        //修改状态
        wx.request({
          url: app.pubData.hostUrl + '/Api/User/contact',
          method: 'post',
          data: {
            uid: app.pubData.userId,
            id: id
          },
          header: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          success: function (res) {
            that.initIndexData();
            //endInitData
          },
          fail: function (e) {
            wx.showToast({
              title: '网络异常！',
              duration: 2000
            });
          },
        })
      },
      fail: function () {
        console.log("拨打电话失败！")
      }
    })
  },

  //上一页
  lastpage: function (e) {
    var that = this;
    var ptype = e.currentTarget.dataset.ptype;
    if (ptype == 1) {
      var page = that.data.zpage;
    } else {
      var page = that.data.fpage;
    }
    if (page <= 1) {
      wx.showToast({
        title: '已经是第一页了！',
        duration: 2000
      });
      return false;
    }
    wx.request({
      url: app.pubData.hostUrl + '/Api/Index/getpage',
      method: 'post',
      data: { page: page - 1, ptype: ptype },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var list = res.data.list;
        if (list == '') {
          wx.showToast({
            title: '没有找到更多数据',
            duration: 2000
          });
          return false;
        }
        if (ptype == 1) {
          that.setData({
            zixun: list,
            zpage: page - 1
          });
        } else {
          that.setData({
            fuwu: list,
            fpage: page - 1
          });
        }
        //endInitData
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          duration: 2000
        });
      },
    })
  },

  //下一页
  nextpage: function (e) {
    var that = this;
    var ptype = e.currentTarget.dataset.ptype;
    if (ptype == 1) {
      var page = that.data.zpage;
    } else {
      var page = that.data.fpage;
    }
    wx.request({
      url: app.pubData.hostUrl + '/Api/Index/getpage',
      method: 'post',
      data: { page: page + 1, ptype: ptype },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var list = res.data.list;
        if (list == '') {
          wx.showToast({
            title: '已经是最后一页了！',
            duration: 2000
          });
          return false;
        }
        if (ptype == 1) {
          that.setData({
            zixun: list,
            zpage: page + 1
          });
        } else {
          that.setData({
            fuwu: list,
            fpage: page + 1
          });
        }
        //endInitData
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          duration: 2000
        });
      },
    })
  },

  //我要发布
  bindFormSubmit: function (e) {
    var that = this;
    var content = e.detail.value.content;
    var dtype = that.data.dtype;
    var userType = app.pubData.userType;
    if (dtype == 1) {
      if (userType < 2) {
        wx.showToast({
          title: '认证律师才可以发布法律服务！',
          duration: 2000
        });
        return false;
      }
    }

    if (!content) {
      wx.showToast({
        title: '请输入供求内容！',
        duration: 2000
      });
      return false;
    }
    console.log(dtype)
    if (dtype < 1 || dtype > 2) {
      wx.showToast({
        title: '网络异常，请稍后再试！',
        duration: 2000
      });
      return false;
    }
    wx.request({
      url: app.pubData.hostUrl + '/Api/User/supply',
      method: 'post',
      data: {
        content: content,
        dtype: dtype,
        uid: app.pubData.userId
      },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if (status == 1) {
          wx.showToast({
            title: '发布成功！',
            duration: 2000
          });
          that.initIndexData();
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

  // 弹窗
  setModalStatus: function (e) {
    var dtype = e.currentTarget.dataset.dtype;
    this.setData({
      dtype: dtype
    });
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    })
    this.animation = animation
    animation.translateY(300).step()
    this.setData({
      animationData: animation.export()
    })
    if (e.currentTarget.dataset.status == 1) {
      this.setData(
        {
          showModalStatus: true
        }
      );
    }
    setTimeout(function () {
      animation.translateY(0).step()
      this.setData({
        animationData: animation
      })
      if (e.currentTarget.dataset.status == 0) {
        this.setData(
          {
            showModalStatus: false
          }
        );
      }
    }.bind(this), 200)
  },

  //加载首页数据
  initIndexData: function () {
    var that = this;
    wx.request({
      url: app.pubData.hostUrl + '/Api/Index/index',
      method: 'post',
      data: {},
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log(res)
        var ggtop = res.data.ggtop;
        var zicate = res.data.zicate;
        var prolist = res.data.prolist;
        var news = res.data.news;
        var gong = res.data.gong;
        var qiu = res.data.qiu;
        var tel = res.data.tel;
        var shopList = res.data.shop;
        var lslist = res.data.lslist;
        var zixun = res.data.zixun;
        var fuwu = res.data.fuwu;
        var anli = res.data.anli;
        var legal = res.data.legal;
        //that.initProductData(data);
        that.setData({
          imgUrls: ggtop,
          zicate: zicate,
          productData: prolist,
          news: news,
          gong: gong,
          qiu: qiu,
          tel:tel,
          shopList:shopList,
          lslist:lslist,
          zixun:zixun,
          fuwu:fuwu,
          anli:anli,
          legal:legal
        });
        //endInitData
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！err:index',
          duration: 2000
        });
      },
    })
  },

  //热门资讯 加载更多
  loadMore: function (e) {
    var that = this;
    var page = that.data.page;
    wx.request({
      url: app.pubData.hostUrl + '/Api/Index/getlist',
      method: 'post',
      data: { page: page },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var news = res.data.news;
        if (news == '') {
          wx.showToast({
            title: '没有找到更多数据',
            duration: 2000
          });
          return false;
        }
        that.setData({
          news: that.data.news.concat(news),
          page: page + 1
        });
        //endInitData
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          duration: 2000
        });
      },
    })
  },

  // 事务所点击跳转
  feilei: function (e) {
    var title = e.currentTarget.dataset.title;
    var id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../synopsis/synopsis?title=' + title + '&shopId=' + id,
    })
  },

  // 景区
  jing: function (e) {
    var id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../detail/detail?proId=' + id,
    })
  },

  // 资讯
  jumpDetails: function (e) {
    var newsId = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../news/news?newsId=' + newsId,
      success: function (res) {
        // success
      },
      fail: function () {
        // fail
      },
      complete: function () {
        // complete
      }
    })
  },

  // tab切换
  tabFun: function (e) {
    //获取触发事件组件的dataset属性 
    var _datasetId = e.target.dataset.id;
    var _obj = {};
    _obj.curHdIndex = _datasetId;
    _obj.curBdIndex = _datasetId;
    this.setData({
      tabArr: _obj
    });
  },
  changeIndicatorDots: function (e) {
    this.setData({
      indicatorDots: !this.data.indicatorDots
    })
  },
  changeAutoplay: function (e) {
    this.setData({
      autoplay: !this.data.autoplay
    })
  },
  intervalChange: function (e) {
    this.setData({
      interval: e.detail.value
    })
  },
  durationChange: function (e) {
    this.setData({
      duration: e.detail.value
    })
  },
  onLoad: function (options) {

  },

  onShow: function () {
    //加载首页数据
    this.initIndexData();
  },

  zilist:function (e) {
    var cid = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../zilist/zilist?cid='+cid,
    })
  },

  moreLs:function () {
    wx.switchTab({
      url: '../attorney/attorney'
    })
  },

  intro:function (e) {
    var ls_id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../intro/intro?ls_id=' + ls_id,
    })
  },
  zdetail: function (e) {
    var zi_id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../reply/reply?zi_id=' + zi_id,
    })
  },
  fdetail: function (e) {
    var fu_id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../fudetail/fudetail?fu_id=' + fu_id,
    })
  },
  //分享
  onShareAppMessage: function () {
    return {
      title: '广州打官司',
      path: '/pages/index/index',
      success: function (res) {
        // 分享成功
      },
      fail: function (res) {
        // 分享失败
      }
    }
  }

})