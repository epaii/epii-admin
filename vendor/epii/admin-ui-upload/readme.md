
install

```json
{
    "require": {
        "epii/admin-ui-upload": ">=0.0.1"
    }
}
```

初始化方式

```php
 //网站可访问的接口 和上传接收器 如果不传递则为默认上传处理器
 AdminUiUpload::init(string $upload_url,string $class = LocalFileUploader::class);
 
 

//如果使用默认处理器需要设置 保存路径前缀，和能访问此路径的 http 网址前缀

LocalFileUploader::init(string $upload_dir, string $url_pre);
 

 

```

在设置的$upload_url 对应的php文件中

``` 
  echo AdminUiUpload::doUpload();
       exit;


```


前台 

```php
 <button data-upload="1"  id="btn1" data-input-id="id1"     data-img-id="show1" data-img-style="width:100px;height:200px">上传1</button>

```

支持的属性有

``` 
data-input-id="id1" //对应的值input 控件id
data-img-id="show1"  // 如果是单个图片，则可设置img 控件的id
data-multiple="1"  //是否支持多个文件上传
data-maxcount="2"  //文件的最大数量 ，如果多个有用
data-imgs-id="show1" // 如果是多个图片，则可设置div 控件的id，多图片预览
data-mimetype="jpg,gif,png,jpeg" //支持的文件类型 默认值为 jpg,gif,png,jpeg
data-img-style="width:200px;height:100px" //如果是图片，可设置每一个图片的样式
data-maxsize="2048kb" //文件大小

data-upload-success="fun1" //设置上传成功的回调
data-upload-complete="fun1" //设置上传完成后的
data-upload-progress="fun1" //设置上传进度回调

```
