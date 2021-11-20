# 使用 hyperf 框架搭建的 json rpc 服务 demo，注册中心使用 consul

## 前期准备

- 使用 docker 搭建开发环境

```shell
docker run --name codes \
-v /Users/pudongping/glory/codes:/codes \
-p 9510:9510 \
-p 9511:9511 \
-p 9512:9512 -it \
--privileged -u root \
--entrypoint /bin/sh \
hyperf/hyperf:7.4-alpine-v3.11-swoole
```

## 如果直接想使用我提供的 demo 的话，则：

- 使用 git 拉取我的 demo 源代码

```shell
git clone https://github.com/pudongping/hyperf-json-rpc-demo.git
```

- 分别进入 `server-provider` 和 `server-consumer` 目录复制一份配置文件

```shell
cp server-provider/.env.example server-provider/.env
cp server-consumer/.env.example server-consumer/.env
```

- 分别进入 `server-provider` 和 `server-consumer` 目录，下载依赖包

```shell
composer install
```

## 如果你想自己重新搭建一份的话，则：

- 创建服务端项目 （服务提供者）

> 需要进入 docker 环境中创建

```shell
composer create-project hyperf/hyperf-skeleton server-provider
```

- 创建客户端项目（服务消费者）

```shell
composer create-project hyperf/hyperf-skeleton server-consumer
```

> 为了更好的演示，创建项目时，我们全部一路回车，不对框架做任何设置，如果你想看我更改了哪些位置的话，你可以通过查看我 git 的提交变动来进行更改。  
> 服务提供者修改详见 git commit 记录为 `18594b9719b19eb6e79027d7260fd96e17339e34` 内容  
> 服务消费者修改详见 git commit 记录为 `3da8ec24e87da35b934aab8c4296af7a948e5341` 内容  


## 安装 consul

> 这里需要注意的是，因为我们的 hyperf 服务是跑在 docker 里面的，如果我们直接在我们的电脑本机安装 consul 的话，此时可能是会出现问题的，因为
> consul 会有一个健康检查的机制（consul 会轮训我们的服务，consul 会以类似于 127.0.0.1:9512 的形式访问我们的服务，以便判断我们的服务是否处于健康状态，
> 但是其实 consul 是无法访问到 127.0.0.1:9512 服务的，但是我们却可以通过浏览器访问到 127.0.0.1:9512 的服务）我们必须要使用 docker 启动 consul，
> 否则你的服务是无法使用 consul 的，这里目前我是这么解决的，如果你有更好的解决方案，欢迎随时跟我讨论。

```shell

# 拉取 latest 版本镜像
docker pull consul

# 拉取指定版本的 consul 镜像，这里以 1.3.0 版本示例
docker pull consul:1.3.0

# 从 consul 镜像生成 alex-consul 容器
docker run --name alex-consul -p 8500:8500 -e CONSUL_BIND_INTERFACE=eth0 -d consul

# 访问 consul ui 界面
# 浏览器直接请求 127.0.0.1:8500 
# 或者直接以本地电脑的 ip 做请求，比如：192.168.0.101:8500
# 如果服务生产者或者服务消费者都在 docker 环境里面，则需要将 consul 的连接地址设置成本地电脑的 ip 地址访问，比如设置成 192.168.0.101:8500

# 直接通过重启 docker 容器的方式重启 consul 或者关闭 consul
# 关闭本地 consul
docker stop alex-consul

# 启动本地 consul
docker start alex-consul
```

## 设置服务提供者 （server-provider） 和服务消费者（server-consumer） 中 consul 相关配置信息

这里因为我们的 consul 是使用 docker 搭建的，因此在我们的服务中设置 consul 连接信息时可以有两种方式：

第一种：直接使用我们本机电脑局域网的 ip 地址，比如我本机电脑所在局域网的 ip 地址为：`192.168.0.101`，那么我们可以设置成 `192.168.0.101:8500`

第二种：直接设置成 consul docker 容器的 ip 地址

```shell
# 查看 consul 所在的 docker 容器 ip 地址
docker inspect alex-consul | grep IPAddress

# 比如此时的容器的 ip 地址为：172.17.0.3 那么则需要设置成 `172.17.0.3:8500`
```

## 测试

> 都需要先进入 docker 环境中

- 开启服务提供者服务

```shell

# 开启服务提供者服务
cd server-provider && php bin/hyperf.php start

```

- 我们可以使用浏览器访问 `127.0.0.1:8500` 或者 `192.168.0.101:8500` 看到 `Services` 已经有服务处于注册状态了

> 默认 consul 会注册一个 Services 名为 `consul` 的服务。

- 开启服务消费者服务

```shell

# 开启服务消费者服务
cd server-consumer && php bin/hyperf.php start

```

- 测试访问

```shell
curl 127.0.0.1:9511/index/test
```

回到服务消费者控制台，我们可以看到有如下输出

```shell

string(19) "测试加法 ====> "
int(5)
string(19) "测试减法 ====> "
int(-1)

```

表示我们已经测试成功了！