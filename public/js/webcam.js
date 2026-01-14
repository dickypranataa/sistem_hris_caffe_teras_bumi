// WebcamJS v1.0.26
(function (window) {
    var Webcam = {
        version: "1.0.26",
        // globals
        protocol: location.protocol.match(/https/i) ? "https" : "http",
        loaded: false, // true when webcam movie finishes loading
        live: false, // true when webcam is initialized and ready to snap
        userMedia: true, // true when getUserMedia is supported natively

        params: {
            width: 0,
            height: 0,
            dest_width: 0,
            dest_height: 0,
            image_format: "jpeg",
            jpeg_quality: 90,
            enable_flash: true,
            force_flash: false,
            flip_horiz: false,
            fps: 30,
            upload_name: "webcam",
            constraints: null,
            swfURL: "", // URI to webcam.swf movie (defaults to the js location)
            flashNotDetectedText:
                "ERROR: No Adobe Flash Player detected.  Webcam.js relies on Flash for browsers that do not support getUserMedia (like IE8).",
            noInterfaceFoundText:
                "ERROR: No supported webcam interface found. Please upgrade to a modern browser like Chrome, Firefox or Edge.",
            unfreeze_snap: true,
            iosPlaceholderText: "Click here to open camera.",
            user_callback: null,
            user_canvas: null,
        },

        errors: {
            FlashError: "Flash Player Error",
            WebcamError: "Webcam Error",
        },

        hooks: {},

        init: function () {
            // initialize, check for getUserMedia support
            var self = this;

            // Setup getUserMedia, with polyfills for older browsers
            // Adapted from: https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
            this.mediaDevices =
                navigator.mediaDevices && navigator.mediaDevices.getUserMedia
                    ? navigator.mediaDevices
                    : navigator.mozGetUserMedia || navigator.webkitGetUserMedia
                    ? {
                          getUserMedia: function (c) {
                              return new Promise(function (y, n) {
                                  (
                                      navigator.mozGetUserMedia ||
                                      navigator.webkitGetUserMedia
                                  ).call(navigator, c, y, n);
                              });
                          },
                      }
                    : null;

            window.URL =
                window.URL || window.webkitURL || window.mozURL || window.msURL;
            this.userMedia =
                this.userMedia && !!this.mediaDevices && !!window.URL;

            if (navigator.userAgent.match(/Firefox\D+(\d+)/)) {
                if (parseInt(RegExp.$1, 10) < 21) this.userMedia = null;
            }

            // Older versions of firefox (< 21) apparently claim support but user media does not actually work
            if (this.userMedia) {
                window.addEventListener("beforeunload", function (event) {
                    self.reset();
                });
            }
        },

        attach: function (elem) {
            // create webcam preview and attach to DOM element
            // pass in actual DOM reference, ID, or CSS selector
            if (typeof elem == "string") {
                elem =
                    document.getElementById(elem) ||
                    document.querySelector(elem);
            }
            if (!elem) {
                return this.dispatch(
                    "error",
                    new Error("Could not locate DOM element to attach to.")
                );
            }
            this.container = elem;
            elem.innerHTML = ""; // start with empty element

            // insert "peg" element, which we will use to keep video centered in container
            var peg = document.createElement("div");
            elem.appendChild(peg);
            this.peg = peg;

            // set width/height if not already set
            if (!this.params.width) this.params.width = elem.offsetWidth;
            if (!this.params.height) this.params.height = elem.offsetHeight;

            // set defaults for dest_width / dest_height
            if (!this.params.dest_width)
                this.params.dest_width = this.params.width;
            if (!this.params.dest_height)
                this.params.dest_height = this.params.height;

            this.userMedia =
                _userMedia === undefined ? this.userMedia : _userMedia;
            // if force_flash is set, disable userMedia
            if (this.params.force_flash) _userMedia = this.userMedia;
            if (this.params.force_flash) this.userMedia = null;

            // check for default fps
            if (typeof this.params.fps !== "number") this.params.fps = 30;

            // adjust scale if dest_width or dest_height is different
            var scaleX = this.params.width / this.params.dest_width;
            var scaleY = this.params.height / this.params.dest_height;

            if (this.userMedia) {
                // setup getUserMedia
                var video = document.createElement("video");
                video.setAttribute("autoplay", "autoplay");
                video.setAttribute("playsinline", "playsinline"); // Needed for iOS 11+
                video.style.width = "" + this.params.dest_width + "px";
                video.style.height = "" + this.params.dest_height + "px";

                if (scaleX != 1.0 || scaleY != 1.0) {
                    elem.style.overflow = "hidden";
                    video.style.webkitTransformOrigin = "0px 0px";
                    video.style.mozTransformOrigin = "0px 0px";
                    video.style.msTransformOrigin = "0px 0px";
                    video.style.oTransformOrigin = "0px 0px";
                    video.style.transformOrigin = "0px 0px";
                    video.style.webkitTransform =
                        "scaleX(" + scaleX + ") scaleY(" + scaleY + ")";
                    video.style.mozTransform =
                        "scaleX(" + scaleX + ") scaleY(" + scaleY + ")";
                    video.style.msTransform =
                        "scaleX(" + scaleX + ") scaleY(" + scaleY + ")";
                    video.style.oTransform =
                        "scaleX(" + scaleX + ") scaleY(" + scaleY + ")";
                    video.style.transform =
                        "scaleX(" + scaleX + ") scaleY(" + scaleY + ")";
                }

                // add video element to dom
                elem.appendChild(video);
                this.video = video;

                // ask user for access to their camera
                var self = this;
                this.mediaDevices
                    .getUserMedia({
                        audio: false,
                        video: this.params.constraints || {
                            mandatory: {
                                minWidth: this.params.dest_width,
                                minHeight: this.params.dest_height,
                            },
                        },
                    })
                    .then(function (stream) {
                        // got access, attach stream to video
                        video.onloadedmetadata = function (e) {
                            self.stream = stream;
                            self.loaded = true;
                            self.live = true;
                            self.dispatch("live");
                            self.flip();
                        };
                        // as window.URL.createObjectURL() is deprecated, adding a check so that it works in Safari.
                        // older browsers may not have srcObject
                        if ("srcObject" in video) {
                            video.srcObject = stream;
                        } else {
                            // using URL.createObjectURL() as fallback for older browsers
                            video.src = window.URL.createObjectURL(stream);
                        }
                    })
                    .catch(function (err) {
                        // JH 2016-07-31 Instead of issuing an error only on failure, now trying to repeat with a default fire settings
                        if (self.params.constraints) {
                            self.params.constraints = null;
                            self.attach(elem);
                        } else {
                            return self.dispatch("error", err);
                        }
                    });
            } else {
                // flash fallback would go here, but removed for brevity in this context
                // as modern browsers use getUserMedia.
                // Assuming modern browser for this Laravel project.
                this.dispatch(
                    "error",
                    new Error(this.params.noInterfaceFoundText)
                );
            }
        },

        reset: function () {
            // shutdown camera, reset to default state
            if (this.preview_active) this.unfreeze();

            // attempt to fix issue #64
            this.unflip();

            if (this.userMedia) {
                if (this.stream) {
                    if (this.stream.getTracks) {
                        this.stream.getTracks().forEach(function (track) {
                            track.stop();
                        });
                    } else if (this.stream.stop) {
                        this.stream.stop();
                    }
                }
                delete this.stream;
                delete this.video;
            }

            if (this.container) {
                this.container.innerHTML = "";
                delete this.container;
            }

            this.loaded = false;
            this.live = false;
        },

        set: function () {
            // set one or more params
            // variable argument list: 1 param = hash, 2 params = key, value
            if (arguments.length == 1) {
                for (var key in arguments[0]) {
                    this.params[key] = arguments[0][key];
                }
            } else {
                this.params[arguments[0]] = arguments[1];
            }
        },

        on: function (name, callback) {
            // set callback hook
            // supported hooks: onLoad, onError, onLive
            name = name.replace(/^on/i, "").toLowerCase();
            if (!this.hooks[name]) this.hooks[name] = [];
            this.hooks[name].push(callback);
        },

        off: function (name, callback) {
            // remove callback hook
            name = name.replace(/^on/i, "").toLowerCase();
            if (this.hooks[name]) {
                if (callback) {
                    var idx = this.hooks[name].indexOf(callback);
                    if (idx > -1) this.hooks[name].splice(idx, 1);
                } else {
                    this.hooks[name] = [];
                }
            }
        },

        dispatch: function () {
            // fire hook callback, passing optional value to it
            var name = arguments[0].replace(/^on/i, "").toLowerCase();
            var args = Array.prototype.slice.call(arguments, 1);

            if (this.hooks[name] && this.hooks[name].length) {
                for (var i = 0, len = this.hooks[name].length; i < len; i++) {
                    var hook = this.hooks[name][i];

                    if (typeof hook == "function") {
                        // callback is function reference, call directly
                        hook.apply(this, args);
                    } else if (typeof hook == "object" && hook.length == 2) {
                        // callback is PHP-style object instance, method name pair
                        hook[0][hook[1]].apply(hook[0], args);
                    } else if (window[hook]) {
                        // callback is global function name
                        window[hook].apply(window, args);
                    }
                } // loop
                return true;
            } else if (name == "error") {
                var message;
                if (
                    args[0] instanceof FlashError ||
                    args[0] instanceof HTML5Error
                ) {
                    message = args[0].message;
                } else {
                    message =
                        "Could not access webcam: " +
                        args[0].name +
                        ": " +
                        args[0].message +
                        " " +
                        args[0].toString();
                }

                // default error handler if no custom one specified
                alert("Webcam.js Error: " + message);
            }

            return false; // no hook fired
        },

        snap: function (user_callback, user_canvas) {
            // take snapshot and return image data uri
            var self = this;

            if (!this.loaded)
                return this.dispatch(
                    "error",
                    new Error("Webcam is not loaded yet")
                );
            if (!user_callback)
                return this.dispatch(
                    "error",
                    new Error(
                        "Please provide a callback function or canvas to snap()"
                    )
                );

            // if user_canvas is not provided, create one
            if (!user_canvas) {
                var canvas = document.createElement("canvas");
                canvas.width = this.params.dest_width;
                canvas.height = this.params.dest_height;
            } else {
                var canvas = user_canvas;
            }
            var context = canvas.getContext("2d");

            // flip canvas horizontally if requested
            if (this.params.flip_horiz) {
                context.translate(this.params.dest_width, 0);
                context.scale(-1, 1);
            }

            // draw video frame into canvas
            var func = function () {
                context.drawImage(
                    self.video,
                    0,
                    0,
                    self.params.dest_width,
                    self.params.dest_height
                );

                if (self.params.image_format === "png") {
                    // create data uri
                    var data_uri = canvas.toDataURL("image/png");
                } else {
                    // create data uri (jpeg)
                    var data_uri = canvas.toDataURL(
                        "image/jpeg",
                        self.params.jpeg_quality / 100
                    );
                }

                // unflip canvas if requested
                if (self.params.flip_horiz) {
                    context.scale(-1, 1);
                    context.translate(-this.params.dest_width, 0);
                }

                if (user_callback) user_callback(data_uri);
            };

            if (this.params.unfreeze_snap) this.unfreeze();

            func();
        },

        freeze: function () {
            // show preview, freeze camera
            var self = this;
            var params = this.params;
            var canvas = document.createElement("canvas");
            canvas.width = this.params.dest_width;
            canvas.height = this.params.dest_height;
            var context = canvas.getContext("2d");

            // flip canvas horizontally if requested
            if (this.params.flip_horiz) {
                context.translate(this.params.dest_width, 0);
                context.scale(-1, 1);
            }

            context.drawImage(
                this.video,
                0,
                0,
                this.params.dest_width,
                this.params.dest_height
            );

            // unflip canvas if requested
            if (this.params.flip_horiz) {
                context.scale(-1, 1);
                context.translate(-this.params.dest_width, 0);
            }

            this.preview_active = true;
            this.preview_canvas = canvas;

            this.container.appendChild(canvas);
            this.video.style.display = "none";
        },

        unfreeze: function () {
            // cancel preview, resume camera
            if (this.preview_active) {
                this.container.removeChild(this.preview_canvas);
                delete this.preview_canvas;
                this.video.style.display = "block";
                this.preview_active = false;
            }
        },

        flip: function () {
            // flip container horiz (mirror mode)
            if (this.params.flip_horiz) {
                var sty = this.container.style;
                sty.webkitTransform = "scaleX(-1)";
                sty.mozTransform = "scaleX(-1)";
                sty.msTransform = "scaleX(-1)";
                sty.oTransform = "scaleX(-1)";
                sty.transform = "scaleX(-1)";
                sty.filter = "FlipH";
                sty.msFilter = "FlipH";
            }
        },

        unflip: function () {
            // unflip container horiz (mirror mode)
            if (this.params.flip_horiz) {
                var sty = this.container.style;
                sty.webkitTransform = "scaleX(1)";
                sty.mozTransform = "scaleX(1)";
                sty.msTransform = "scaleX(1)";
                sty.oTransform = "scaleX(1)";
                sty.transform = "scaleX(1)";
                sty.filter = "";
                sty.msFilter = "";
            }
        },
    };

    Webcam.init();

    if (typeof define === "function" && define.amd) {
        define(function () {
            return Webcam;
        });
    } else if (typeof module === "object" && module.exports) {
        module.exports = Webcam;
    } else {
        window.Webcam = Webcam;
    }
})(window);
var _userMedia;
