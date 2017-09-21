var reg = /^((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)$/;
var app = getApp();
Page({
  data:{
    user : {},
    disabled: false,
    array:["个人","律师",],
    index:0,
    blNumber:'',
    truename:'',
    tel:'',
    audit:0,
    ptype:0,
    imageSrc:'',
    shop_name:'',
    cz:'',
    service:'',
    dizhi:'',
    photo_ls:''
  },
  // 上传图片
  chooseImage: function () {
    var that = this
    wx.chooseImage({
      count: 1,
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有  
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        var imageSrc = res.tempFilePaths[0];
        wx.uploadFile({
          url: app.pubData.hostUrl + '/Api/User/uploadbl',
          filePath: imageSrc,
          name: 'img',
          formData: {
            uid: app.pubData.userId
          },
          header: {
            'Content-Type': 'multipart/form-data'
          },
          success: function (res) {
            //console.log('uploadImage success, res is:', res);
            var statusCode = res.statusCode;
            if (statusCode==200){
              wx.showToast({
                title: '上传成功',
                icon: 'success',
                duration: 2000
              })
              that.setData({
                imageSrc
              })
            }
          },
          fail: function ({errMsg}) {
            console.log('uploadImage fail, errMsg is', errMsg)
            wx.showToast({
              title: '上传失败',
              icon: 'success',
              duration: 2000
            })
          }
        })

      },
      fail: function ({errMsg}) {
        console.log('chooseImage fail, err is', errMsg)
        wx.showToast({
          title: '图片选择失败',
          icon: 'success',
          duration: 2000
        })
      }
    })
  },

  // 上传图片
  chooseImage2: function () {
    var that = this
    wx.chooseImage({
      count: 1,
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有  
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        var photo_ls = res.tempFilePaths[0];
        wx.uploadFile({
          url: app.pubData.hostUrl + '/Api/User/uploadls',
          filePath: photo_ls,
          name: 'img',
          formData: {
            uid: app.pubData.userId
          },
          header: {
            'Content-Type': 'multipart/form-data'
          },
          success: function (res) {
            //console.log('uploadImage success, res is:', res);
            var statusCode = res.statusCode;
            if (statusCode == 200) {
              wx.showToast({
                title: '上传成功',
                icon: 'success',
                duration: 2000
              })
              that.setData({
                photo_ls
              })
            }
          },
          fail: function ({ errMsg }) {
            console.log('uploadImage fail, errMsg is', errMsg)
            wx.showToast({
              title: '上传失败',
              icon: 'success',
              duration: 2000
            })
          }
        })

      },
      fail: function ({ errMsg }) {
        console.log('chooseImage fail, err is', errMsg)
        wx.showToast({
          title: '图片选择失败',
          icon: 'success',
          duration: 2000
        })
      }
    })
  },

//类型选择 更改事件
bindPickerChange: function(e) {
  console.log(e.detail.value);
    this.setData({
      index: e.detail.value
    })
  },

//营业执照编号失去焦点事件
numberInputEvent:function(e){
    this.setData({
      blNumber:e.detail.value
    })
 },

//窗体加载事件
onLoad: function (options) {
    var that = this;
    var uid = app.pubData.userId;
    wx.request({
      url: app.pubData.hostUrl + '/Api/User/userinfo',
      method: 'post',
      data: {
        uid: uid
      },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if (status == 1) {
          var user = res.data.userinfo;
          var tel = user.tel;
          if(tel==false){
            wx.showToast({
              title: '请先绑定手机号！',
              duration: 2000
            });
            setTimeout(function () {
              wx.redirectTo({
                url: '../register/register',
              })
            },2200);
            
          }
          that.setData({
            blNumber: user.bl_number,
            truename: user.truename,
            tel: user.tel,
            digest: user.digest,
            zyjy: user.zyjy,
            dizhi: user.dizhi,
            service: user.service,
            cz: user.cz,
            shop_name: user.shop_name,
            audit: user.audit,
            ptype:user.type,
            imageSrc: user.bl_photo,
            photo_ls: user.photo_ls,
            user: user
          });
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

//提交认证
formDataCommit: function (e) {
    var that = this;
    var userType = 2;
    var truename = that.data.truename;
    var tel = that.data.tel;
    var shop_name = that.data.shop_name;
    var dizhi = that.data.dizhi;
    var service = that.data.service;
    var cz = that.data.cz;
    var digest = that.data.digest;
    var zyjy = that.data.zyjy;
    var bl_number = that.data.blNumber;
    // if (userType == 1 && !bl_number){
    //     wx.showToast({
    //       title: '请输入营业执照编号！',
    //       duration: 2500
    //     });
    //     return false;
    // }
    
    wx.request({
      url: app.pubData.hostUrl + '/Api/User/user_edit',
      method: 'post',
      data: { 
        uid:app.pubData.userId,
        usertype: userType,
        truename: truename,
        tel:tel,
        shop_name:shop_name,
        dizhi:dizhi,
        service:service,
        cz:cz,
        digest:digest,
        zyjy:zyjy
        //bl_number: bl_number
      },
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        var status = res.data.status;
        if (status == 1) {
          that.setData({
            disabled: true
          });
          if (userType==2){
            wx.showToast({
              title: '提交成功，请耐心等待审核！',
              duration: 2000
            });
          }else{
            wx.showToast({
              title: '保存成功！',
              duration: 2000
            });
          }
        } else {
          wx.showToast({
            title: res.data.err,
            duration: 2000
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

//姓名焦点事件
bindKeyname(e) {
  console.log(e.detail.value);
  this.setData({
    truename: e.detail.value,
  })
},
//律师所焦点事件
bindshop(e) {
  console.log(e.detail.value);
  this.setData({
    shop_name: e.detail.value,
  })
},
//地址焦点事件
bindaddress(e) {
  console.log(e.detail.value);
  this.setData({
    dizhi: e.detail.value,
  })
},
//服务项目焦点事件
bindservice(e) {
  console.log(e.detail.value);
  this.setData({
    service: e.detail.value,
  })
},
//传真焦点事件
bindcz(e) {
  console.log(e.detail.value);
  this.setData({
    cz: e.detail.value,
  })
},
//律师简介焦点事件
binddigest(e) {
  console.log(e.detail.value);
  this.setData({
    digest: e.detail.value,
  })
},
//执业经验焦点事件
bindzyjy(e) {
  console.log(e.detail.value);
  this.setData({
    zyjy: e.detail.value,
  })
},

//手机焦点事件
bindTelInput (e){
  console.log(e.detail.value);
    this.setData({
      tel: e.detail.value,
      userver : reg.test(e.detail.value)
    }) 
},

  watch (){
    console.log(1)
  }
})