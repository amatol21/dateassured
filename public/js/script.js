/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/adapter.js":
/*!*********************************!*\
  !*** ./resources/js/adapter.js ***!
  \*********************************/
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof2(obj) { "@babel/helpers - typeof"; return _typeof2 = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof2(obj); }
(function (f) {
  if (( false ? 0 : _typeof2(exports)) === "object" && "object" !== "undefined") {
    module.exports = f();
  } else if (true) {
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (f),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else { var g; }
})(function () {
  var define, module, exports;
  return function () {
    function r(e, n, t) {
      function o(i, f) {
        if (!n[i]) {
          if (!e[i]) {
            var c = undefined;
            if (!f && c) return require(i, !0);
            if (u) return u(i, !0);
            var a = new Error("Cannot find module '" + i + "'");
            throw a.code = "MODULE_NOT_FOUND", a;
          }
          var p = n[i] = {
            exports: {}
          };
          e[i][0].call(p.exports, function (r) {
            var n = e[i][1][r];
            return o(n || r);
          }, p, p.exports, r, e, n, t);
        }
        return n[i].exports;
      }
      for (var u = undefined, i = 0; i < t.length; i++) o(t[i]);
      return o;
    }
    return r;
  }()({
    1: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */

      'use strict';

      var _adapter_factory = require('./adapter_factory.js');
      var adapter = (0, _adapter_factory.adapterFactory)({
        window: typeof window === 'undefined' ? undefined : window
      });
      module.exports = adapter; // this is the difference from adapter_core.
    }, {
      "./adapter_factory.js": 2
    }],
    2: [function (require, module, exports) {
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      exports.adapterFactory = adapterFactory;
      var _utils = require('./utils');
      var utils = _interopRequireWildcard(_utils);
      var _chrome_shim = require('./chrome/chrome_shim');
      var chromeShim = _interopRequireWildcard(_chrome_shim);
      var _firefox_shim = require('./firefox/firefox_shim');
      var firefoxShim = _interopRequireWildcard(_firefox_shim);
      var _safari_shim = require('./safari/safari_shim');
      var safariShim = _interopRequireWildcard(_safari_shim);
      var _common_shim = require('./common_shim');
      var commonShim = _interopRequireWildcard(_common_shim);
      var _sdp = require('sdp');
      var sdp = _interopRequireWildcard(_sdp);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }

      // Shimming starts here.
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      function adapterFactory() {
        var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
          window = _ref.window;
        var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {
          shimChrome: true,
          shimFirefox: true,
          shimSafari: true
        };

        // Utils.
        var logging = utils.log;
        var browserDetails = utils.detectBrowser(window);
        var adapter = {
          browserDetails: browserDetails,
          commonShim: commonShim,
          extractVersion: utils.extractVersion,
          disableLog: utils.disableLog,
          disableWarnings: utils.disableWarnings,
          // Expose sdp as a convenience. For production apps include directly.
          sdp: sdp
        };

        // Shim browser if found.
        switch (browserDetails.browser) {
          case 'chrome':
            if (!chromeShim || !chromeShim.shimPeerConnection || !options.shimChrome) {
              logging('Chrome shim is not included in this adapter release.');
              return adapter;
            }
            if (browserDetails.version === null) {
              logging('Chrome shim can not determine version, not shimming.');
              return adapter;
            }
            logging('adapter.js shimming chrome.');
            // Export to the adapter global object visible in the browser.
            adapter.browserShim = chromeShim;

            // Must be called before shimPeerConnection.
            commonShim.shimAddIceCandidateNullOrEmpty(window, browserDetails);
            chromeShim.shimGetUserMedia(window, browserDetails);
            chromeShim.shimMediaStream(window, browserDetails);
            chromeShim.shimPeerConnection(window, browserDetails);
            chromeShim.shimOnTrack(window, browserDetails);
            chromeShim.shimAddTrackRemoveTrack(window, browserDetails);
            chromeShim.shimGetSendersWithDtmf(window, browserDetails);
            chromeShim.shimGetStats(window, browserDetails);
            chromeShim.shimSenderReceiverGetStats(window, browserDetails);
            chromeShim.fixNegotiationNeeded(window, browserDetails);
            commonShim.shimRTCIceCandidate(window, browserDetails);
            commonShim.shimConnectionState(window, browserDetails);
            commonShim.shimMaxMessageSize(window, browserDetails);
            commonShim.shimSendThrowTypeError(window, browserDetails);
            commonShim.removeExtmapAllowMixed(window, browserDetails);
            break;
          case 'firefox':
            if (!firefoxShim || !firefoxShim.shimPeerConnection || !options.shimFirefox) {
              logging('Firefox shim is not included in this adapter release.');
              return adapter;
            }
            logging('adapter.js shimming firefox.');
            // Export to the adapter global object visible in the browser.
            adapter.browserShim = firefoxShim;

            // Must be called before shimPeerConnection.
            commonShim.shimAddIceCandidateNullOrEmpty(window, browserDetails);
            firefoxShim.shimGetUserMedia(window, browserDetails);
            firefoxShim.shimPeerConnection(window, browserDetails);
            firefoxShim.shimOnTrack(window, browserDetails);
            firefoxShim.shimRemoveStream(window, browserDetails);
            firefoxShim.shimSenderGetStats(window, browserDetails);
            firefoxShim.shimReceiverGetStats(window, browserDetails);
            firefoxShim.shimRTCDataChannel(window, browserDetails);
            firefoxShim.shimAddTransceiver(window, browserDetails);
            firefoxShim.shimGetParameters(window, browserDetails);
            firefoxShim.shimCreateOffer(window, browserDetails);
            firefoxShim.shimCreateAnswer(window, browserDetails);
            commonShim.shimRTCIceCandidate(window, browserDetails);
            commonShim.shimConnectionState(window, browserDetails);
            commonShim.shimMaxMessageSize(window, browserDetails);
            commonShim.shimSendThrowTypeError(window, browserDetails);
            break;
          case 'safari':
            if (!safariShim || !options.shimSafari) {
              logging('Safari shim is not included in this adapter release.');
              return adapter;
            }
            logging('adapter.js shimming safari.');
            // Export to the adapter global object visible in the browser.
            adapter.browserShim = safariShim;

            // Must be called before shimCallbackAPI.
            commonShim.shimAddIceCandidateNullOrEmpty(window, browserDetails);
            safariShim.shimRTCIceServerUrls(window, browserDetails);
            safariShim.shimCreateOfferLegacy(window, browserDetails);
            safariShim.shimCallbacksAPI(window, browserDetails);
            safariShim.shimLocalStreamsAPI(window, browserDetails);
            safariShim.shimRemoteStreamsAPI(window, browserDetails);
            safariShim.shimTrackEventTransceiver(window, browserDetails);
            safariShim.shimGetUserMedia(window, browserDetails);
            safariShim.shimAudioContext(window, browserDetails);
            commonShim.shimRTCIceCandidate(window, browserDetails);
            commonShim.shimMaxMessageSize(window, browserDetails);
            commonShim.shimSendThrowTypeError(window, browserDetails);
            commonShim.removeExtmapAllowMixed(window, browserDetails);
            break;
          default:
            logging('Unsupported browser!');
            break;
        }
        return adapter;
      }

      // Browser shims.
    }, {
      "./chrome/chrome_shim": 3,
      "./common_shim": 6,
      "./firefox/firefox_shim": 7,
      "./safari/safari_shim": 10,
      "./utils": 11,
      "sdp": 12
    }],
    3: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      exports.shimGetDisplayMedia = exports.shimGetUserMedia = undefined;
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      var _getusermedia = require('./getusermedia');
      Object.defineProperty(exports, 'shimGetUserMedia', {
        enumerable: true,
        get: function get() {
          return _getusermedia.shimGetUserMedia;
        }
      });
      var _getdisplaymedia = require('./getdisplaymedia');
      Object.defineProperty(exports, 'shimGetDisplayMedia', {
        enumerable: true,
        get: function get() {
          return _getdisplaymedia.shimGetDisplayMedia;
        }
      });
      exports.shimMediaStream = shimMediaStream;
      exports.shimOnTrack = shimOnTrack;
      exports.shimGetSendersWithDtmf = shimGetSendersWithDtmf;
      exports.shimGetStats = shimGetStats;
      exports.shimSenderReceiverGetStats = shimSenderReceiverGetStats;
      exports.shimAddTrackRemoveTrackWithNative = shimAddTrackRemoveTrackWithNative;
      exports.shimAddTrackRemoveTrack = shimAddTrackRemoveTrack;
      exports.shimPeerConnection = shimPeerConnection;
      exports.fixNegotiationNeeded = fixNegotiationNeeded;
      var _utils = require('../utils.js');
      var utils = _interopRequireWildcard(_utils);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }
      function _defineProperty(obj, key, value) {
        if (key in obj) {
          Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
          });
        } else {
          obj[key] = value;
        }
        return obj;
      }
      function shimMediaStream(window) {
        window.MediaStream = window.MediaStream || window.webkitMediaStream;
      }
      function shimOnTrack(window) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection && !('ontrack' in window.RTCPeerConnection.prototype)) {
          Object.defineProperty(window.RTCPeerConnection.prototype, 'ontrack', {
            get: function get() {
              return this._ontrack;
            },
            set: function set(f) {
              if (this._ontrack) {
                this.removeEventListener('track', this._ontrack);
              }
              this.addEventListener('track', this._ontrack = f);
            },
            enumerable: true,
            configurable: true
          });
          var origSetRemoteDescription = window.RTCPeerConnection.prototype.setRemoteDescription;
          window.RTCPeerConnection.prototype.setRemoteDescription = function setRemoteDescription() {
            var _this = this;
            if (!this._ontrackpoly) {
              this._ontrackpoly = function (e) {
                // onaddstream does not fire when a track is added to an existing
                // stream. But stream.onaddtrack is implemented so we use that.
                e.stream.addEventListener('addtrack', function (te) {
                  var receiver = void 0;
                  if (window.RTCPeerConnection.prototype.getReceivers) {
                    receiver = _this.getReceivers().find(function (r) {
                      return r.track && r.track.id === te.track.id;
                    });
                  } else {
                    receiver = {
                      track: te.track
                    };
                  }
                  var event = new Event('track');
                  event.track = te.track;
                  event.receiver = receiver;
                  event.transceiver = {
                    receiver: receiver
                  };
                  event.streams = [e.stream];
                  _this.dispatchEvent(event);
                });
                e.stream.getTracks().forEach(function (track) {
                  var receiver = void 0;
                  if (window.RTCPeerConnection.prototype.getReceivers) {
                    receiver = _this.getReceivers().find(function (r) {
                      return r.track && r.track.id === track.id;
                    });
                  } else {
                    receiver = {
                      track: track
                    };
                  }
                  var event = new Event('track');
                  event.track = track;
                  event.receiver = receiver;
                  event.transceiver = {
                    receiver: receiver
                  };
                  event.streams = [e.stream];
                  _this.dispatchEvent(event);
                });
              };
              this.addEventListener('addstream', this._ontrackpoly);
            }
            return origSetRemoteDescription.apply(this, arguments);
          };
        } else {
          // even if RTCRtpTransceiver is in window, it is only used and
          // emitted in unified-plan. Unfortunately this means we need
          // to unconditionally wrap the event.
          utils.wrapPeerConnectionEvent(window, 'track', function (e) {
            if (!e.transceiver) {
              Object.defineProperty(e, 'transceiver', {
                value: {
                  receiver: e.receiver
                }
              });
            }
            return e;
          });
        }
      }
      function shimGetSendersWithDtmf(window) {
        // Overrides addTrack/removeTrack, depends on shimAddTrackRemoveTrack.
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection && !('getSenders' in window.RTCPeerConnection.prototype) && 'createDTMFSender' in window.RTCPeerConnection.prototype) {
          var shimSenderWithDtmf = function shimSenderWithDtmf(pc, track) {
            return {
              track: track,
              get dtmf() {
                if (this._dtmf === undefined) {
                  if (track.kind === 'audio') {
                    this._dtmf = pc.createDTMFSender(track);
                  } else {
                    this._dtmf = null;
                  }
                }
                return this._dtmf;
              },
              _pc: pc
            };
          };

          // augment addTrack when getSenders is not available.
          if (!window.RTCPeerConnection.prototype.getSenders) {
            window.RTCPeerConnection.prototype.getSenders = function getSenders() {
              this._senders = this._senders || [];
              return this._senders.slice(); // return a copy of the internal state.
            };

            var origAddTrack = window.RTCPeerConnection.prototype.addTrack;
            window.RTCPeerConnection.prototype.addTrack = function addTrack(track, stream) {
              var sender = origAddTrack.apply(this, arguments);
              if (!sender) {
                sender = shimSenderWithDtmf(this, track);
                this._senders.push(sender);
              }
              return sender;
            };
            var origRemoveTrack = window.RTCPeerConnection.prototype.removeTrack;
            window.RTCPeerConnection.prototype.removeTrack = function removeTrack(sender) {
              origRemoveTrack.apply(this, arguments);
              var idx = this._senders.indexOf(sender);
              if (idx !== -1) {
                this._senders.splice(idx, 1);
              }
            };
          }
          var origAddStream = window.RTCPeerConnection.prototype.addStream;
          window.RTCPeerConnection.prototype.addStream = function addStream(stream) {
            var _this2 = this;
            this._senders = this._senders || [];
            origAddStream.apply(this, [stream]);
            stream.getTracks().forEach(function (track) {
              _this2._senders.push(shimSenderWithDtmf(_this2, track));
            });
          };
          var origRemoveStream = window.RTCPeerConnection.prototype.removeStream;
          window.RTCPeerConnection.prototype.removeStream = function removeStream(stream) {
            var _this3 = this;
            this._senders = this._senders || [];
            origRemoveStream.apply(this, [stream]);
            stream.getTracks().forEach(function (track) {
              var sender = _this3._senders.find(function (s) {
                return s.track === track;
              });
              if (sender) {
                // remove sender
                _this3._senders.splice(_this3._senders.indexOf(sender), 1);
              }
            });
          };
        } else if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection && 'getSenders' in window.RTCPeerConnection.prototype && 'createDTMFSender' in window.RTCPeerConnection.prototype && window.RTCRtpSender && !('dtmf' in window.RTCRtpSender.prototype)) {
          var origGetSenders = window.RTCPeerConnection.prototype.getSenders;
          window.RTCPeerConnection.prototype.getSenders = function getSenders() {
            var _this4 = this;
            var senders = origGetSenders.apply(this, []);
            senders.forEach(function (sender) {
              return sender._pc = _this4;
            });
            return senders;
          };
          Object.defineProperty(window.RTCRtpSender.prototype, 'dtmf', {
            get: function get() {
              if (this._dtmf === undefined) {
                if (this.track.kind === 'audio') {
                  this._dtmf = this._pc.createDTMFSender(this.track);
                } else {
                  this._dtmf = null;
                }
              }
              return this._dtmf;
            }
          });
        }
      }
      function shimGetStats(window) {
        if (!window.RTCPeerConnection) {
          return;
        }
        var origGetStats = window.RTCPeerConnection.prototype.getStats;
        window.RTCPeerConnection.prototype.getStats = function getStats() {
          var _this5 = this;
          var _arguments = Array.prototype.slice.call(arguments),
            selector = _arguments[0],
            onSucc = _arguments[1],
            onErr = _arguments[2];

          // If selector is a function then we are in the old style stats so just
          // pass back the original getStats format to avoid breaking old users.

          if (arguments.length > 0 && typeof selector === 'function') {
            return origGetStats.apply(this, arguments);
          }

          // When spec-style getStats is supported, return those when called with
          // either no arguments or the selector argument is null.
          if (origGetStats.length === 0 && (arguments.length === 0 || typeof selector !== 'function')) {
            return origGetStats.apply(this, []);
          }
          var fixChromeStats_ = function fixChromeStats_(response) {
            var standardReport = {};
            var reports = response.result();
            reports.forEach(function (report) {
              var standardStats = {
                id: report.id,
                timestamp: report.timestamp,
                type: {
                  localcandidate: 'local-candidate',
                  remotecandidate: 'remote-candidate'
                }[report.type] || report.type
              };
              report.names().forEach(function (name) {
                standardStats[name] = report.stat(name);
              });
              standardReport[standardStats.id] = standardStats;
            });
            return standardReport;
          };

          // shim getStats with maplike support
          var makeMapStats = function makeMapStats(stats) {
            return new Map(Object.keys(stats).map(function (key) {
              return [key, stats[key]];
            }));
          };
          if (arguments.length >= 2) {
            var successCallbackWrapper_ = function successCallbackWrapper_(response) {
              onSucc(makeMapStats(fixChromeStats_(response)));
            };
            return origGetStats.apply(this, [successCallbackWrapper_, selector]);
          }

          // promise-support
          return new Promise(function (resolve, reject) {
            origGetStats.apply(_this5, [function (response) {
              resolve(makeMapStats(fixChromeStats_(response)));
            }, reject]);
          }).then(onSucc, onErr);
        };
      }
      function shimSenderReceiverGetStats(window) {
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection && window.RTCRtpSender && window.RTCRtpReceiver)) {
          return;
        }

        // shim sender stats.
        if (!('getStats' in window.RTCRtpSender.prototype)) {
          var origGetSenders = window.RTCPeerConnection.prototype.getSenders;
          if (origGetSenders) {
            window.RTCPeerConnection.prototype.getSenders = function getSenders() {
              var _this6 = this;
              var senders = origGetSenders.apply(this, []);
              senders.forEach(function (sender) {
                return sender._pc = _this6;
              });
              return senders;
            };
          }
          var origAddTrack = window.RTCPeerConnection.prototype.addTrack;
          if (origAddTrack) {
            window.RTCPeerConnection.prototype.addTrack = function addTrack() {
              var sender = origAddTrack.apply(this, arguments);
              sender._pc = this;
              return sender;
            };
          }
          window.RTCRtpSender.prototype.getStats = function getStats() {
            var sender = this;
            return this._pc.getStats().then(function (result) {
              return (
                /* Note: this will include stats of all senders that
                 *   send a track with the same id as sender.track as
                 *   it is not possible to identify the RTCRtpSender.
                 */
                utils.filterStats(result, sender.track, true)
              );
            });
          };
        }

        // shim receiver stats.
        if (!('getStats' in window.RTCRtpReceiver.prototype)) {
          var origGetReceivers = window.RTCPeerConnection.prototype.getReceivers;
          if (origGetReceivers) {
            window.RTCPeerConnection.prototype.getReceivers = function getReceivers() {
              var _this7 = this;
              var receivers = origGetReceivers.apply(this, []);
              receivers.forEach(function (receiver) {
                return receiver._pc = _this7;
              });
              return receivers;
            };
          }
          utils.wrapPeerConnectionEvent(window, 'track', function (e) {
            e.receiver._pc = e.srcElement;
            return e;
          });
          window.RTCRtpReceiver.prototype.getStats = function getStats() {
            var receiver = this;
            return this._pc.getStats().then(function (result) {
              return utils.filterStats(result, receiver.track, false);
            });
          };
        }
        if (!('getStats' in window.RTCRtpSender.prototype && 'getStats' in window.RTCRtpReceiver.prototype)) {
          return;
        }

        // shim RTCPeerConnection.getStats(track).
        var origGetStats = window.RTCPeerConnection.prototype.getStats;
        window.RTCPeerConnection.prototype.getStats = function getStats() {
          if (arguments.length > 0 && arguments[0] instanceof window.MediaStreamTrack) {
            var track = arguments[0];
            var sender = void 0;
            var receiver = void 0;
            var err = void 0;
            this.getSenders().forEach(function (s) {
              if (s.track === track) {
                if (sender) {
                  err = true;
                } else {
                  sender = s;
                }
              }
            });
            this.getReceivers().forEach(function (r) {
              if (r.track === track) {
                if (receiver) {
                  err = true;
                } else {
                  receiver = r;
                }
              }
              return r.track === track;
            });
            if (err || sender && receiver) {
              return Promise.reject(new DOMException('There are more than one sender or receiver for the track.', 'InvalidAccessError'));
            } else if (sender) {
              return sender.getStats();
            } else if (receiver) {
              return receiver.getStats();
            }
            return Promise.reject(new DOMException('There is no sender or receiver for the track.', 'InvalidAccessError'));
          }
          return origGetStats.apply(this, arguments);
        };
      }
      function shimAddTrackRemoveTrackWithNative(window) {
        // shim addTrack/removeTrack with native variants in order to make
        // the interactions with legacy getLocalStreams behave as in other browsers.
        // Keeps a mapping stream.id => [stream, rtpsenders...]
        window.RTCPeerConnection.prototype.getLocalStreams = function getLocalStreams() {
          var _this8 = this;
          this._shimmedLocalStreams = this._shimmedLocalStreams || {};
          return Object.keys(this._shimmedLocalStreams).map(function (streamId) {
            return _this8._shimmedLocalStreams[streamId][0];
          });
        };
        var origAddTrack = window.RTCPeerConnection.prototype.addTrack;
        window.RTCPeerConnection.prototype.addTrack = function addTrack(track, stream) {
          if (!stream) {
            return origAddTrack.apply(this, arguments);
          }
          this._shimmedLocalStreams = this._shimmedLocalStreams || {};
          var sender = origAddTrack.apply(this, arguments);
          if (!this._shimmedLocalStreams[stream.id]) {
            this._shimmedLocalStreams[stream.id] = [stream, sender];
          } else if (this._shimmedLocalStreams[stream.id].indexOf(sender) === -1) {
            this._shimmedLocalStreams[stream.id].push(sender);
          }
          return sender;
        };
        var origAddStream = window.RTCPeerConnection.prototype.addStream;
        window.RTCPeerConnection.prototype.addStream = function addStream(stream) {
          var _this9 = this;
          this._shimmedLocalStreams = this._shimmedLocalStreams || {};
          stream.getTracks().forEach(function (track) {
            var alreadyExists = _this9.getSenders().find(function (s) {
              return s.track === track;
            });
            if (alreadyExists) {
              throw new DOMException('Track already exists.', 'InvalidAccessError');
            }
          });
          var existingSenders = this.getSenders();
          origAddStream.apply(this, arguments);
          var newSenders = this.getSenders().filter(function (newSender) {
            return existingSenders.indexOf(newSender) === -1;
          });
          this._shimmedLocalStreams[stream.id] = [stream].concat(newSenders);
        };
        var origRemoveStream = window.RTCPeerConnection.prototype.removeStream;
        window.RTCPeerConnection.prototype.removeStream = function removeStream(stream) {
          this._shimmedLocalStreams = this._shimmedLocalStreams || {};
          delete this._shimmedLocalStreams[stream.id];
          return origRemoveStream.apply(this, arguments);
        };
        var origRemoveTrack = window.RTCPeerConnection.prototype.removeTrack;
        window.RTCPeerConnection.prototype.removeTrack = function removeTrack(sender) {
          var _this10 = this;
          this._shimmedLocalStreams = this._shimmedLocalStreams || {};
          if (sender) {
            Object.keys(this._shimmedLocalStreams).forEach(function (streamId) {
              var idx = _this10._shimmedLocalStreams[streamId].indexOf(sender);
              if (idx !== -1) {
                _this10._shimmedLocalStreams[streamId].splice(idx, 1);
              }
              if (_this10._shimmedLocalStreams[streamId].length === 1) {
                delete _this10._shimmedLocalStreams[streamId];
              }
            });
          }
          return origRemoveTrack.apply(this, arguments);
        };
      }
      function shimAddTrackRemoveTrack(window, browserDetails) {
        if (!window.RTCPeerConnection) {
          return;
        }
        // shim addTrack and removeTrack.
        if (window.RTCPeerConnection.prototype.addTrack && browserDetails.version >= 65) {
          return shimAddTrackRemoveTrackWithNative(window);
        }

        // also shim pc.getLocalStreams when addTrack is shimmed
        // to return the original streams.
        var origGetLocalStreams = window.RTCPeerConnection.prototype.getLocalStreams;
        window.RTCPeerConnection.prototype.getLocalStreams = function getLocalStreams() {
          var _this11 = this;
          var nativeStreams = origGetLocalStreams.apply(this);
          this._reverseStreams = this._reverseStreams || {};
          return nativeStreams.map(function (stream) {
            return _this11._reverseStreams[stream.id];
          });
        };
        var origAddStream = window.RTCPeerConnection.prototype.addStream;
        window.RTCPeerConnection.prototype.addStream = function addStream(stream) {
          var _this12 = this;
          this._streams = this._streams || {};
          this._reverseStreams = this._reverseStreams || {};
          stream.getTracks().forEach(function (track) {
            var alreadyExists = _this12.getSenders().find(function (s) {
              return s.track === track;
            });
            if (alreadyExists) {
              throw new DOMException('Track already exists.', 'InvalidAccessError');
            }
          });
          // Add identity mapping for consistency with addTrack.
          // Unless this is being used with a stream from addTrack.
          if (!this._reverseStreams[stream.id]) {
            var newStream = new window.MediaStream(stream.getTracks());
            this._streams[stream.id] = newStream;
            this._reverseStreams[newStream.id] = stream;
            stream = newStream;
          }
          origAddStream.apply(this, [stream]);
        };
        var origRemoveStream = window.RTCPeerConnection.prototype.removeStream;
        window.RTCPeerConnection.prototype.removeStream = function removeStream(stream) {
          this._streams = this._streams || {};
          this._reverseStreams = this._reverseStreams || {};
          origRemoveStream.apply(this, [this._streams[stream.id] || stream]);
          delete this._reverseStreams[this._streams[stream.id] ? this._streams[stream.id].id : stream.id];
          delete this._streams[stream.id];
        };
        window.RTCPeerConnection.prototype.addTrack = function addTrack(track, stream) {
          var _this13 = this;
          if (this.signalingState === 'closed') {
            throw new DOMException('The RTCPeerConnection\'s signalingState is \'closed\'.', 'InvalidStateError');
          }
          var streams = [].slice.call(arguments, 1);
          if (streams.length !== 1 || !streams[0].getTracks().find(function (t) {
            return t === track;
          })) {
            // this is not fully correct but all we can manage without
            // [[associated MediaStreams]] internal slot.
            throw new DOMException('The adapter.js addTrack polyfill only supports a single ' + ' stream which is associated with the specified track.', 'NotSupportedError');
          }
          var alreadyExists = this.getSenders().find(function (s) {
            return s.track === track;
          });
          if (alreadyExists) {
            throw new DOMException('Track already exists.', 'InvalidAccessError');
          }
          this._streams = this._streams || {};
          this._reverseStreams = this._reverseStreams || {};
          var oldStream = this._streams[stream.id];
          if (oldStream) {
            // this is using odd Chrome behaviour, use with caution:
            // https://bugs.chromium.org/p/webrtc/issues/detail?id=7815
            // Note: we rely on the high-level addTrack/dtmf shim to
            // create the sender with a dtmf sender.
            oldStream.addTrack(track);

            // Trigger ONN async.
            Promise.resolve().then(function () {
              _this13.dispatchEvent(new Event('negotiationneeded'));
            });
          } else {
            var newStream = new window.MediaStream([track]);
            this._streams[stream.id] = newStream;
            this._reverseStreams[newStream.id] = stream;
            this.addStream(newStream);
          }
          return this.getSenders().find(function (s) {
            return s.track === track;
          });
        };

        // replace the internal stream id with the external one and
        // vice versa.
        function replaceInternalStreamId(pc, description) {
          var sdp = description.sdp;
          Object.keys(pc._reverseStreams || []).forEach(function (internalId) {
            var externalStream = pc._reverseStreams[internalId];
            var internalStream = pc._streams[externalStream.id];
            sdp = sdp.replace(new RegExp(internalStream.id, 'g'), externalStream.id);
          });
          return new RTCSessionDescription({
            type: description.type,
            sdp: sdp
          });
        }
        function replaceExternalStreamId(pc, description) {
          var sdp = description.sdp;
          Object.keys(pc._reverseStreams || []).forEach(function (internalId) {
            var externalStream = pc._reverseStreams[internalId];
            var internalStream = pc._streams[externalStream.id];
            sdp = sdp.replace(new RegExp(externalStream.id, 'g'), internalStream.id);
          });
          return new RTCSessionDescription({
            type: description.type,
            sdp: sdp
          });
        }
        ['createOffer', 'createAnswer'].forEach(function (method) {
          var nativeMethod = window.RTCPeerConnection.prototype[method];
          var methodObj = _defineProperty({}, method, function () {
            var _this14 = this;
            var args = arguments;
            var isLegacyCall = arguments.length && typeof arguments[0] === 'function';
            if (isLegacyCall) {
              return nativeMethod.apply(this, [function (description) {
                var desc = replaceInternalStreamId(_this14, description);
                args[0].apply(null, [desc]);
              }, function (err) {
                if (args[1]) {
                  args[1].apply(null, err);
                }
              }, arguments[2]]);
            }
            return nativeMethod.apply(this, arguments).then(function (description) {
              return replaceInternalStreamId(_this14, description);
            });
          });
          window.RTCPeerConnection.prototype[method] = methodObj[method];
        });
        var origSetLocalDescription = window.RTCPeerConnection.prototype.setLocalDescription;
        window.RTCPeerConnection.prototype.setLocalDescription = function setLocalDescription() {
          if (!arguments.length || !arguments[0].type) {
            return origSetLocalDescription.apply(this, arguments);
          }
          arguments[0] = replaceExternalStreamId(this, arguments[0]);
          return origSetLocalDescription.apply(this, arguments);
        };

        // TODO: mangle getStats: https://w3c.github.io/webrtc-stats/#dom-rtcmediastreamstats-streamidentifier

        var origLocalDescription = Object.getOwnPropertyDescriptor(window.RTCPeerConnection.prototype, 'localDescription');
        Object.defineProperty(window.RTCPeerConnection.prototype, 'localDescription', {
          get: function get() {
            var description = origLocalDescription.get.apply(this);
            if (description.type === '') {
              return description;
            }
            return replaceInternalStreamId(this, description);
          }
        });
        window.RTCPeerConnection.prototype.removeTrack = function removeTrack(sender) {
          var _this15 = this;
          if (this.signalingState === 'closed') {
            throw new DOMException('The RTCPeerConnection\'s signalingState is \'closed\'.', 'InvalidStateError');
          }
          // We can not yet check for sender instanceof RTCRtpSender
          // since we shim RTPSender. So we check if sender._pc is set.
          if (!sender._pc) {
            throw new DOMException('Argument 1 of RTCPeerConnection.removeTrack ' + 'does not implement interface RTCRtpSender.', 'TypeError');
          }
          var isLocal = sender._pc === this;
          if (!isLocal) {
            throw new DOMException('Sender was not created by this connection.', 'InvalidAccessError');
          }

          // Search for the native stream the senders track belongs to.
          this._streams = this._streams || {};
          var stream = void 0;
          Object.keys(this._streams).forEach(function (streamid) {
            var hasTrack = _this15._streams[streamid].getTracks().find(function (track) {
              return sender.track === track;
            });
            if (hasTrack) {
              stream = _this15._streams[streamid];
            }
          });
          if (stream) {
            if (stream.getTracks().length === 1) {
              // if this is the last track of the stream, remove the stream. This
              // takes care of any shimmed _senders.
              this.removeStream(this._reverseStreams[stream.id]);
            } else {
              // relying on the same odd chrome behaviour as above.
              stream.removeTrack(sender.track);
            }
            this.dispatchEvent(new Event('negotiationneeded'));
          }
        };
      }
      function shimPeerConnection(window, browserDetails) {
        if (!window.RTCPeerConnection && window.webkitRTCPeerConnection) {
          // very basic support for old versions.
          window.RTCPeerConnection = window.webkitRTCPeerConnection;
        }
        if (!window.RTCPeerConnection) {
          return;
        }

        // shim implicit creation of RTCSessionDescription/RTCIceCandidate
        if (browserDetails.version < 53) {
          ['setLocalDescription', 'setRemoteDescription', 'addIceCandidate'].forEach(function (method) {
            var nativeMethod = window.RTCPeerConnection.prototype[method];
            var methodObj = _defineProperty({}, method, function () {
              arguments[0] = new (method === 'addIceCandidate' ? window.RTCIceCandidate : window.RTCSessionDescription)(arguments[0]);
              return nativeMethod.apply(this, arguments);
            });
            window.RTCPeerConnection.prototype[method] = methodObj[method];
          });
        }
      }

      // Attempt to fix ONN in plan-b mode.
      function fixNegotiationNeeded(window, browserDetails) {
        utils.wrapPeerConnectionEvent(window, 'negotiationneeded', function (e) {
          var pc = e.target;
          if (browserDetails.version < 72 || pc.getConfiguration && pc.getConfiguration().sdpSemantics === 'plan-b') {
            if (pc.signalingState !== 'stable') {
              return;
            }
          }
          return e;
        });
      }
    }, {
      "../utils.js": 11,
      "./getdisplaymedia": 4,
      "./getusermedia": 5
    }],
    4: [function (require, module, exports) {
      /*
       *  Copyright (c) 2018 The adapter.js project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      exports.shimGetDisplayMedia = shimGetDisplayMedia;
      function shimGetDisplayMedia(window, getSourceId) {
        if (window.navigator.mediaDevices && 'getDisplayMedia' in window.navigator.mediaDevices) {
          return;
        }
        if (!window.navigator.mediaDevices) {
          return;
        }
        // getSourceId is a function that returns a promise resolving with
        // the sourceId of the screen/window/tab to be shared.
        if (typeof getSourceId !== 'function') {
          console.error('shimGetDisplayMedia: getSourceId argument is not ' + 'a function');
          return;
        }
        window.navigator.mediaDevices.getDisplayMedia = function getDisplayMedia(constraints) {
          return getSourceId(constraints).then(function (sourceId) {
            var widthSpecified = constraints.video && constraints.video.width;
            var heightSpecified = constraints.video && constraints.video.height;
            var frameRateSpecified = constraints.video && constraints.video.frameRate;
            constraints.video = {
              mandatory: {
                chromeMediaSource: 'desktop',
                chromeMediaSourceId: sourceId,
                maxFrameRate: frameRateSpecified || 3
              }
            };
            if (widthSpecified) {
              constraints.video.mandatory.maxWidth = widthSpecified;
            }
            if (heightSpecified) {
              constraints.video.mandatory.maxHeight = heightSpecified;
            }
            return window.navigator.mediaDevices.getUserMedia(constraints);
          });
        };
      }
    }, {}],
    5: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      exports.shimGetUserMedia = shimGetUserMedia;
      var _utils = require('../utils.js');
      var utils = _interopRequireWildcard(_utils);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }
      var logging = utils.log;
      function shimGetUserMedia(window, browserDetails) {
        var navigator = window && window.navigator;
        if (!navigator.mediaDevices) {
          return;
        }
        var constraintsToChrome_ = function constraintsToChrome_(c) {
          if ((typeof c === 'undefined' ? 'undefined' : _typeof(c)) !== 'object' || c.mandatory || c.optional) {
            return c;
          }
          var cc = {};
          Object.keys(c).forEach(function (key) {
            if (key === 'require' || key === 'advanced' || key === 'mediaSource') {
              return;
            }
            var r = _typeof(c[key]) === 'object' ? c[key] : {
              ideal: c[key]
            };
            if (r.exact !== undefined && typeof r.exact === 'number') {
              r.min = r.max = r.exact;
            }
            var oldname_ = function oldname_(prefix, name) {
              if (prefix) {
                return prefix + name.charAt(0).toUpperCase() + name.slice(1);
              }
              return name === 'deviceId' ? 'sourceId' : name;
            };
            if (r.ideal !== undefined) {
              cc.optional = cc.optional || [];
              var oc = {};
              if (typeof r.ideal === 'number') {
                oc[oldname_('min', key)] = r.ideal;
                cc.optional.push(oc);
                oc = {};
                oc[oldname_('max', key)] = r.ideal;
                cc.optional.push(oc);
              } else {
                oc[oldname_('', key)] = r.ideal;
                cc.optional.push(oc);
              }
            }
            if (r.exact !== undefined && typeof r.exact !== 'number') {
              cc.mandatory = cc.mandatory || {};
              cc.mandatory[oldname_('', key)] = r.exact;
            } else {
              ['min', 'max'].forEach(function (mix) {
                if (r[mix] !== undefined) {
                  cc.mandatory = cc.mandatory || {};
                  cc.mandatory[oldname_(mix, key)] = r[mix];
                }
              });
            }
          });
          if (c.advanced) {
            cc.optional = (cc.optional || []).concat(c.advanced);
          }
          return cc;
        };
        var shimConstraints_ = function shimConstraints_(constraints, func) {
          if (browserDetails.version >= 61) {
            return func(constraints);
          }
          constraints = JSON.parse(JSON.stringify(constraints));
          if (constraints && _typeof(constraints.audio) === 'object') {
            var remap = function remap(obj, a, b) {
              if (a in obj && !(b in obj)) {
                obj[b] = obj[a];
                delete obj[a];
              }
            };
            constraints = JSON.parse(JSON.stringify(constraints));
            remap(constraints.audio, 'autoGainControl', 'googAutoGainControl');
            remap(constraints.audio, 'noiseSuppression', 'googNoiseSuppression');
            constraints.audio = constraintsToChrome_(constraints.audio);
          }
          if (constraints && _typeof(constraints.video) === 'object') {
            // Shim facingMode for mobile & surface pro.
            var face = constraints.video.facingMode;
            face = face && ((typeof face === 'undefined' ? 'undefined' : _typeof(face)) === 'object' ? face : {
              ideal: face
            });
            var getSupportedFacingModeLies = browserDetails.version < 66;
            if (face && (face.exact === 'user' || face.exact === 'environment' || face.ideal === 'user' || face.ideal === 'environment') && !(navigator.mediaDevices.getSupportedConstraints && navigator.mediaDevices.getSupportedConstraints().facingMode && !getSupportedFacingModeLies)) {
              delete constraints.video.facingMode;
              var matches = void 0;
              if (face.exact === 'environment' || face.ideal === 'environment') {
                matches = ['back', 'rear'];
              } else if (face.exact === 'user' || face.ideal === 'user') {
                matches = ['front'];
              }
              if (matches) {
                // Look for matches in label, or use last cam for back (typical).
                return navigator.mediaDevices.enumerateDevices().then(function (devices) {
                  devices = devices.filter(function (d) {
                    return d.kind === 'videoinput';
                  });
                  var dev = devices.find(function (d) {
                    return matches.some(function (match) {
                      return d.label.toLowerCase().includes(match);
                    });
                  });
                  if (!dev && devices.length && matches.includes('back')) {
                    dev = devices[devices.length - 1]; // more likely the back cam
                  }

                  if (dev) {
                    constraints.video.deviceId = face.exact ? {
                      exact: dev.deviceId
                    } : {
                      ideal: dev.deviceId
                    };
                  }
                  constraints.video = constraintsToChrome_(constraints.video);
                  logging('chrome: ' + JSON.stringify(constraints));
                  return func(constraints);
                });
              }
            }
            constraints.video = constraintsToChrome_(constraints.video);
          }
          logging('chrome: ' + JSON.stringify(constraints));
          return func(constraints);
        };
        var shimError_ = function shimError_(e) {
          if (browserDetails.version >= 64) {
            return e;
          }
          return {
            name: {
              PermissionDeniedError: 'NotAllowedError',
              PermissionDismissedError: 'NotAllowedError',
              InvalidStateError: 'NotAllowedError',
              DevicesNotFoundError: 'NotFoundError',
              ConstraintNotSatisfiedError: 'OverconstrainedError',
              TrackStartError: 'NotReadableError',
              MediaDeviceFailedDueToShutdown: 'NotAllowedError',
              MediaDeviceKillSwitchOn: 'NotAllowedError',
              TabCaptureError: 'AbortError',
              ScreenCaptureError: 'AbortError',
              DeviceCaptureError: 'AbortError'
            }[e.name] || e.name,
            message: e.message,
            constraint: e.constraint || e.constraintName,
            toString: function toString() {
              return this.name + (this.message && ': ') + this.message;
            }
          };
        };
        var getUserMedia_ = function getUserMedia_(constraints, onSuccess, onError) {
          shimConstraints_(constraints, function (c) {
            navigator.webkitGetUserMedia(c, onSuccess, function (e) {
              if (onError) {
                onError(shimError_(e));
              }
            });
          });
        };
        navigator.getUserMedia = getUserMedia_.bind(navigator);

        // Even though Chrome 45 has navigator.mediaDevices and a getUserMedia
        // function which returns a Promise, it does not accept spec-style
        // constraints.
        if (navigator.mediaDevices.getUserMedia) {
          var origGetUserMedia = navigator.mediaDevices.getUserMedia.bind(navigator.mediaDevices);
          navigator.mediaDevices.getUserMedia = function (cs) {
            return shimConstraints_(cs, function (c) {
              return origGetUserMedia(c).then(function (stream) {
                if (c.audio && !stream.getAudioTracks().length || c.video && !stream.getVideoTracks().length) {
                  stream.getTracks().forEach(function (track) {
                    track.stop();
                  });
                  throw new DOMException('', 'NotFoundError');
                }
                return stream;
              }, function (e) {
                return Promise.reject(shimError_(e));
              });
            });
          };
        }
      }
    }, {
      "../utils.js": 11
    }],
    6: [function (require, module, exports) {
      /*
       *  Copyright (c) 2017 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      exports.shimRTCIceCandidate = shimRTCIceCandidate;
      exports.shimMaxMessageSize = shimMaxMessageSize;
      exports.shimSendThrowTypeError = shimSendThrowTypeError;
      exports.shimConnectionState = shimConnectionState;
      exports.removeExtmapAllowMixed = removeExtmapAllowMixed;
      exports.shimAddIceCandidateNullOrEmpty = shimAddIceCandidateNullOrEmpty;
      var _sdp = require('sdp');
      var _sdp2 = _interopRequireDefault(_sdp);
      var _utils = require('./utils');
      var utils = _interopRequireWildcard(_utils);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {
          "default": obj
        };
      }
      function shimRTCIceCandidate(window) {
        // foundation is arbitrarily chosen as an indicator for full support for
        // https://w3c.github.io/webrtc-pc/#rtcicecandidate-interface
        if (!window.RTCIceCandidate || window.RTCIceCandidate && 'foundation' in window.RTCIceCandidate.prototype) {
          return;
        }
        var NativeRTCIceCandidate = window.RTCIceCandidate;
        window.RTCIceCandidate = function RTCIceCandidate(args) {
          // Remove the a= which shouldn't be part of the candidate string.
          if ((typeof args === 'undefined' ? 'undefined' : _typeof(args)) === 'object' && args.candidate && args.candidate.indexOf('a=') === 0) {
            args = JSON.parse(JSON.stringify(args));
            args.candidate = args.candidate.substr(2);
          }
          if (args.candidate && args.candidate.length) {
            // Augment the native candidate with the parsed fields.
            var nativeCandidate = new NativeRTCIceCandidate(args);
            var parsedCandidate = _sdp2["default"].parseCandidate(args.candidate);
            var augmentedCandidate = Object.assign(nativeCandidate, parsedCandidate);

            // Add a serializer that does not serialize the extra attributes.
            augmentedCandidate.toJSON = function toJSON() {
              return {
                candidate: augmentedCandidate.candidate,
                sdpMid: augmentedCandidate.sdpMid,
                sdpMLineIndex: augmentedCandidate.sdpMLineIndex,
                usernameFragment: augmentedCandidate.usernameFragment
              };
            };
            return augmentedCandidate;
          }
          return new NativeRTCIceCandidate(args);
        };
        window.RTCIceCandidate.prototype = NativeRTCIceCandidate.prototype;

        // Hook up the augmented candidate in onicecandidate and
        // addEventListener('icecandidate', ...)
        utils.wrapPeerConnectionEvent(window, 'icecandidate', function (e) {
          if (e.candidate) {
            Object.defineProperty(e, 'candidate', {
              value: new window.RTCIceCandidate(e.candidate),
              writable: 'false'
            });
          }
          return e;
        });
      }
      function shimMaxMessageSize(window, browserDetails) {
        if (!window.RTCPeerConnection) {
          return;
        }
        if (!('sctp' in window.RTCPeerConnection.prototype)) {
          Object.defineProperty(window.RTCPeerConnection.prototype, 'sctp', {
            get: function get() {
              return typeof this._sctp === 'undefined' ? null : this._sctp;
            }
          });
        }
        var sctpInDescription = function sctpInDescription(description) {
          if (!description || !description.sdp) {
            return false;
          }
          var sections = _sdp2["default"].splitSections(description.sdp);
          sections.shift();
          return sections.some(function (mediaSection) {
            var mLine = _sdp2["default"].parseMLine(mediaSection);
            return mLine && mLine.kind === 'application' && mLine.protocol.indexOf('SCTP') !== -1;
          });
        };
        var getRemoteFirefoxVersion = function getRemoteFirefoxVersion(description) {
          // TODO: Is there a better solution for detecting Firefox?
          var match = description.sdp.match(/mozilla...THIS_IS_SDPARTA-(\d+)/);
          if (match === null || match.length < 2) {
            return -1;
          }
          var version = parseInt(match[1], 10);
          // Test for NaN (yes, this is ugly)
          return version !== version ? -1 : version;
        };
        var getCanSendMaxMessageSize = function getCanSendMaxMessageSize(remoteIsFirefox) {
          // Every implementation we know can send at least 64 KiB.
          // Note: Although Chrome is technically able to send up to 256 KiB, the
          //       data does not reach the other peer reliably.
          //       See: https://bugs.chromium.org/p/webrtc/issues/detail?id=8419
          var canSendMaxMessageSize = 65536;
          if (browserDetails.browser === 'firefox') {
            if (browserDetails.version < 57) {
              if (remoteIsFirefox === -1) {
                // FF < 57 will send in 16 KiB chunks using the deprecated PPID
                // fragmentation.
                canSendMaxMessageSize = 16384;
              } else {
                // However, other FF (and RAWRTC) can reassemble PPID-fragmented
                // messages. Thus, supporting ~2 GiB when sending.
                canSendMaxMessageSize = 2147483637;
              }
            } else if (browserDetails.version < 60) {
              // Currently, all FF >= 57 will reset the remote maximum message size
              // to the default value when a data channel is created at a later
              // stage. :(
              // See: https://bugzilla.mozilla.org/show_bug.cgi?id=1426831
              canSendMaxMessageSize = browserDetails.version === 57 ? 65535 : 65536;
            } else {
              // FF >= 60 supports sending ~2 GiB
              canSendMaxMessageSize = 2147483637;
            }
          }
          return canSendMaxMessageSize;
        };
        var getMaxMessageSize = function getMaxMessageSize(description, remoteIsFirefox) {
          // Note: 65536 bytes is the default value from the SDP spec. Also,
          //       every implementation we know supports receiving 65536 bytes.
          var maxMessageSize = 65536;

          // FF 57 has a slightly incorrect default remote max message size, so
          // we need to adjust it here to avoid a failure when sending.
          // See: https://bugzilla.mozilla.org/show_bug.cgi?id=1425697
          if (browserDetails.browser === 'firefox' && browserDetails.version === 57) {
            maxMessageSize = 65535;
          }
          var match = _sdp2["default"].matchPrefix(description.sdp, 'a=max-message-size:');
          if (match.length > 0) {
            maxMessageSize = parseInt(match[0].substr(19), 10);
          } else if (browserDetails.browser === 'firefox' && remoteIsFirefox !== -1) {
            // If the maximum message size is not present in the remote SDP and
            // both local and remote are Firefox, the remote peer can receive
            // ~2 GiB.
            maxMessageSize = 2147483637;
          }
          return maxMessageSize;
        };
        var origSetRemoteDescription = window.RTCPeerConnection.prototype.setRemoteDescription;
        window.RTCPeerConnection.prototype.setRemoteDescription = function setRemoteDescription() {
          this._sctp = null;
          // Chrome decided to not expose .sctp in plan-b mode.
          // As usual, adapter.js has to do an 'ugly worakaround'
          // to cover up the mess.
          if (browserDetails.browser === 'chrome' && browserDetails.version >= 76) {
            var _getConfiguration = this.getConfiguration(),
              sdpSemantics = _getConfiguration.sdpSemantics;
            if (sdpSemantics === 'plan-b') {
              Object.defineProperty(this, 'sctp', {
                get: function get() {
                  return typeof this._sctp === 'undefined' ? null : this._sctp;
                },
                enumerable: true,
                configurable: true
              });
            }
          }
          if (sctpInDescription(arguments[0])) {
            // Check if the remote is FF.
            var isFirefox = getRemoteFirefoxVersion(arguments[0]);

            // Get the maximum message size the local peer is capable of sending
            var canSendMMS = getCanSendMaxMessageSize(isFirefox);

            // Get the maximum message size of the remote peer.
            var remoteMMS = getMaxMessageSize(arguments[0], isFirefox);

            // Determine final maximum message size
            var maxMessageSize = void 0;
            if (canSendMMS === 0 && remoteMMS === 0) {
              maxMessageSize = Number.POSITIVE_INFINITY;
            } else if (canSendMMS === 0 || remoteMMS === 0) {
              maxMessageSize = Math.max(canSendMMS, remoteMMS);
            } else {
              maxMessageSize = Math.min(canSendMMS, remoteMMS);
            }

            // Create a dummy RTCSctpTransport object and the 'maxMessageSize'
            // attribute.
            var sctp = {};
            Object.defineProperty(sctp, 'maxMessageSize', {
              get: function get() {
                return maxMessageSize;
              }
            });
            this._sctp = sctp;
          }
          return origSetRemoteDescription.apply(this, arguments);
        };
      }
      function shimSendThrowTypeError(window) {
        if (!(window.RTCPeerConnection && 'createDataChannel' in window.RTCPeerConnection.prototype)) {
          return;
        }

        // Note: Although Firefox >= 57 has a native implementation, the maximum
        //       message size can be reset for all data channels at a later stage.
        //       See: https://bugzilla.mozilla.org/show_bug.cgi?id=1426831

        function wrapDcSend(dc, pc) {
          var origDataChannelSend = dc.send;
          dc.send = function send() {
            var data = arguments[0];
            var length = data.length || data.size || data.byteLength;
            if (dc.readyState === 'open' && pc.sctp && length > pc.sctp.maxMessageSize) {
              throw new TypeError('Message too large (can send a maximum of ' + pc.sctp.maxMessageSize + ' bytes)');
            }
            return origDataChannelSend.apply(dc, arguments);
          };
        }
        var origCreateDataChannel = window.RTCPeerConnection.prototype.createDataChannel;
        window.RTCPeerConnection.prototype.createDataChannel = function createDataChannel() {
          var dataChannel = origCreateDataChannel.apply(this, arguments);
          wrapDcSend(dataChannel, this);
          return dataChannel;
        };
        utils.wrapPeerConnectionEvent(window, 'datachannel', function (e) {
          wrapDcSend(e.channel, e.target);
          return e;
        });
      }

      /* shims RTCConnectionState by pretending it is the same as iceConnectionState.
       * See https://bugs.chromium.org/p/webrtc/issues/detail?id=6145#c12
       * for why this is a valid hack in Chrome. In Firefox it is slightly incorrect
       * since DTLS failures would be hidden. See
       * https://bugzilla.mozilla.org/show_bug.cgi?id=1265827
       * for the Firefox tracking bug.
       */
      function shimConnectionState(window) {
        if (!window.RTCPeerConnection || 'connectionState' in window.RTCPeerConnection.prototype) {
          return;
        }
        var proto = window.RTCPeerConnection.prototype;
        Object.defineProperty(proto, 'connectionState', {
          get: function get() {
            return {
              completed: 'connected',
              checking: 'connecting'
            }[this.iceConnectionState] || this.iceConnectionState;
          },
          enumerable: true,
          configurable: true
        });
        Object.defineProperty(proto, 'onconnectionstatechange', {
          get: function get() {
            return this._onconnectionstatechange || null;
          },
          set: function set(cb) {
            if (this._onconnectionstatechange) {
              this.removeEventListener('connectionstatechange', this._onconnectionstatechange);
              delete this._onconnectionstatechange;
            }
            if (cb) {
              this.addEventListener('connectionstatechange', this._onconnectionstatechange = cb);
            }
          },
          enumerable: true,
          configurable: true
        });
        ['setLocalDescription', 'setRemoteDescription'].forEach(function (method) {
          var origMethod = proto[method];
          proto[method] = function () {
            if (!this._connectionstatechangepoly) {
              this._connectionstatechangepoly = function (e) {
                var pc = e.target;
                if (pc._lastConnectionState !== pc.connectionState) {
                  pc._lastConnectionState = pc.connectionState;
                  var newEvent = new Event('connectionstatechange', e);
                  pc.dispatchEvent(newEvent);
                }
                return e;
              };
              this.addEventListener('iceconnectionstatechange', this._connectionstatechangepoly);
            }
            return origMethod.apply(this, arguments);
          };
        });
      }
      function removeExtmapAllowMixed(window, browserDetails) {
        /* remove a=extmap-allow-mixed for webrtc.org < M71 */
        if (!window.RTCPeerConnection) {
          return;
        }
        if (browserDetails.browser === 'chrome' && browserDetails.version >= 71) {
          return;
        }
        if (browserDetails.browser === 'safari' && browserDetails.version >= 605) {
          return;
        }
        var nativeSRD = window.RTCPeerConnection.prototype.setRemoteDescription;
        window.RTCPeerConnection.prototype.setRemoteDescription = function setRemoteDescription(desc) {
          if (desc && desc.sdp && desc.sdp.indexOf('\na=extmap-allow-mixed') !== -1) {
            var sdp = desc.sdp.split('\n').filter(function (line) {
              return line.trim() !== 'a=extmap-allow-mixed';
            }).join('\n');
            // Safari enforces read-only-ness of RTCSessionDescription fields.
            if (window.RTCSessionDescription && desc instanceof window.RTCSessionDescription) {
              arguments[0] = new window.RTCSessionDescription({
                type: desc.type,
                sdp: sdp
              });
            } else {
              desc.sdp = sdp;
            }
          }
          return nativeSRD.apply(this, arguments);
        };
      }
      function shimAddIceCandidateNullOrEmpty(window, browserDetails) {
        // Support for addIceCandidate(null or undefined)
        // as well as addIceCandidate({candidate: "", ...})
        // https://bugs.chromium.org/p/chromium/issues/detail?id=978582
        // Note: must be called before other polyfills which change the signature.
        if (!(window.RTCPeerConnection && window.RTCPeerConnection.prototype)) {
          return;
        }
        var nativeAddIceCandidate = window.RTCPeerConnection.prototype.addIceCandidate;
        if (!nativeAddIceCandidate || nativeAddIceCandidate.length === 0) {
          return;
        }
        window.RTCPeerConnection.prototype.addIceCandidate = function addIceCandidate() {
          if (!arguments[0]) {
            if (arguments[1]) {
              arguments[1].apply(null);
            }
            return Promise.resolve();
          }
          // Firefox 68+ emits and processes {candidate: "", ...}, ignore
          // in older versions.
          // Native support for ignoring exists for Chrome M77+.
          // Safari ignores as well, exact version unknown but works in the same
          // version that also ignores addIceCandidate(null).
          if ((browserDetails.browser === 'chrome' && browserDetails.version < 78 || browserDetails.browser === 'firefox' && browserDetails.version < 68 || browserDetails.browser === 'safari') && arguments[0] && arguments[0].candidate === '') {
            return Promise.resolve();
          }
          return nativeAddIceCandidate.apply(this, arguments);
        };
      }
    }, {
      "./utils": 11,
      "sdp": 12
    }],
    7: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      exports.shimGetDisplayMedia = exports.shimGetUserMedia = undefined;
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      var _getusermedia = require('./getusermedia');
      Object.defineProperty(exports, 'shimGetUserMedia', {
        enumerable: true,
        get: function get() {
          return _getusermedia.shimGetUserMedia;
        }
      });
      var _getdisplaymedia = require('./getdisplaymedia');
      Object.defineProperty(exports, 'shimGetDisplayMedia', {
        enumerable: true,
        get: function get() {
          return _getdisplaymedia.shimGetDisplayMedia;
        }
      });
      exports.shimOnTrack = shimOnTrack;
      exports.shimPeerConnection = shimPeerConnection;
      exports.shimSenderGetStats = shimSenderGetStats;
      exports.shimReceiverGetStats = shimReceiverGetStats;
      exports.shimRemoveStream = shimRemoveStream;
      exports.shimRTCDataChannel = shimRTCDataChannel;
      exports.shimAddTransceiver = shimAddTransceiver;
      exports.shimGetParameters = shimGetParameters;
      exports.shimCreateOffer = shimCreateOffer;
      exports.shimCreateAnswer = shimCreateAnswer;
      var _utils = require('../utils');
      var utils = _interopRequireWildcard(_utils);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }
      function _defineProperty(obj, key, value) {
        if (key in obj) {
          Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
          });
        } else {
          obj[key] = value;
        }
        return obj;
      }
      function shimOnTrack(window) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCTrackEvent && 'receiver' in window.RTCTrackEvent.prototype && !('transceiver' in window.RTCTrackEvent.prototype)) {
          Object.defineProperty(window.RTCTrackEvent.prototype, 'transceiver', {
            get: function get() {
              return {
                receiver: this.receiver
              };
            }
          });
        }
      }
      function shimPeerConnection(window, browserDetails) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) !== 'object' || !(window.RTCPeerConnection || window.mozRTCPeerConnection)) {
          return; // probably media.peerconnection.enabled=false in about:config
        }

        if (!window.RTCPeerConnection && window.mozRTCPeerConnection) {
          // very basic support for old versions.
          window.RTCPeerConnection = window.mozRTCPeerConnection;
        }
        if (browserDetails.version < 53) {
          // shim away need for obsolete RTCIceCandidate/RTCSessionDescription.
          ['setLocalDescription', 'setRemoteDescription', 'addIceCandidate'].forEach(function (method) {
            var nativeMethod = window.RTCPeerConnection.prototype[method];
            var methodObj = _defineProperty({}, method, function () {
              arguments[0] = new (method === 'addIceCandidate' ? window.RTCIceCandidate : window.RTCSessionDescription)(arguments[0]);
              return nativeMethod.apply(this, arguments);
            });
            window.RTCPeerConnection.prototype[method] = methodObj[method];
          });
        }
        var modernStatsTypes = {
          inboundrtp: 'inbound-rtp',
          outboundrtp: 'outbound-rtp',
          candidatepair: 'candidate-pair',
          localcandidate: 'local-candidate',
          remotecandidate: 'remote-candidate'
        };
        var nativeGetStats = window.RTCPeerConnection.prototype.getStats;
        window.RTCPeerConnection.prototype.getStats = function getStats() {
          var _arguments = Array.prototype.slice.call(arguments),
            selector = _arguments[0],
            onSucc = _arguments[1],
            onErr = _arguments[2];
          return nativeGetStats.apply(this, [selector || null]).then(function (stats) {
            if (browserDetails.version < 53 && !onSucc) {
              // Shim only promise getStats with spec-hyphens in type names
              // Leave callback version alone; misc old uses of forEach before Map
              try {
                stats.forEach(function (stat) {
                  stat.type = modernStatsTypes[stat.type] || stat.type;
                });
              } catch (e) {
                if (e.name !== 'TypeError') {
                  throw e;
                }
                // Avoid TypeError: "type" is read-only, in old versions. 34-43ish
                stats.forEach(function (stat, i) {
                  stats.set(i, Object.assign({}, stat, {
                    type: modernStatsTypes[stat.type] || stat.type
                  }));
                });
              }
            }
            return stats;
          }).then(onSucc, onErr);
        };
      }
      function shimSenderGetStats(window) {
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection && window.RTCRtpSender)) {
          return;
        }
        if (window.RTCRtpSender && 'getStats' in window.RTCRtpSender.prototype) {
          return;
        }
        var origGetSenders = window.RTCPeerConnection.prototype.getSenders;
        if (origGetSenders) {
          window.RTCPeerConnection.prototype.getSenders = function getSenders() {
            var _this = this;
            var senders = origGetSenders.apply(this, []);
            senders.forEach(function (sender) {
              return sender._pc = _this;
            });
            return senders;
          };
        }
        var origAddTrack = window.RTCPeerConnection.prototype.addTrack;
        if (origAddTrack) {
          window.RTCPeerConnection.prototype.addTrack = function addTrack() {
            var sender = origAddTrack.apply(this, arguments);
            sender._pc = this;
            return sender;
          };
        }
        window.RTCRtpSender.prototype.getStats = function getStats() {
          return this.track ? this._pc.getStats(this.track) : Promise.resolve(new Map());
        };
      }
      function shimReceiverGetStats(window) {
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection && window.RTCRtpSender)) {
          return;
        }
        if (window.RTCRtpSender && 'getStats' in window.RTCRtpReceiver.prototype) {
          return;
        }
        var origGetReceivers = window.RTCPeerConnection.prototype.getReceivers;
        if (origGetReceivers) {
          window.RTCPeerConnection.prototype.getReceivers = function getReceivers() {
            var _this2 = this;
            var receivers = origGetReceivers.apply(this, []);
            receivers.forEach(function (receiver) {
              return receiver._pc = _this2;
            });
            return receivers;
          };
        }
        utils.wrapPeerConnectionEvent(window, 'track', function (e) {
          e.receiver._pc = e.srcElement;
          return e;
        });
        window.RTCRtpReceiver.prototype.getStats = function getStats() {
          return this._pc.getStats(this.track);
        };
      }
      function shimRemoveStream(window) {
        if (!window.RTCPeerConnection || 'removeStream' in window.RTCPeerConnection.prototype) {
          return;
        }
        window.RTCPeerConnection.prototype.removeStream = function removeStream(stream) {
          var _this3 = this;
          utils.deprecated('removeStream', 'removeTrack');
          this.getSenders().forEach(function (sender) {
            if (sender.track && stream.getTracks().includes(sender.track)) {
              _this3.removeTrack(sender);
            }
          });
        };
      }
      function shimRTCDataChannel(window) {
        // rename DataChannel to RTCDataChannel (native fix in FF60):
        // https://bugzilla.mozilla.org/show_bug.cgi?id=1173851
        if (window.DataChannel && !window.RTCDataChannel) {
          window.RTCDataChannel = window.DataChannel;
        }
      }
      function shimAddTransceiver(window) {
        // https://github.com/webrtcHacks/adapter/issues/998#issuecomment-516921647
        // Firefox ignores the init sendEncodings options passed to addTransceiver
        // https://bugzilla.mozilla.org/show_bug.cgi?id=1396918
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection)) {
          return;
        }
        var origAddTransceiver = window.RTCPeerConnection.prototype.addTransceiver;
        if (origAddTransceiver) {
          window.RTCPeerConnection.prototype.addTransceiver = function addTransceiver() {
            this.setParametersPromises = [];
            var initParameters = arguments[1];
            var shouldPerformCheck = initParameters && 'sendEncodings' in initParameters;
            if (shouldPerformCheck) {
              // If sendEncodings params are provided, validate grammar
              initParameters.sendEncodings.forEach(function (encodingParam) {
                if ('rid' in encodingParam) {
                  var ridRegex = /^[a-z0-9]{0,16}$/i;
                  if (!ridRegex.test(encodingParam.rid)) {
                    throw new TypeError('Invalid RID value provided.');
                  }
                }
                if ('scaleResolutionDownBy' in encodingParam) {
                  if (!(parseFloat(encodingParam.scaleResolutionDownBy) >= 1.0)) {
                    throw new RangeError('scale_resolution_down_by must be >= 1.0');
                  }
                }
                if ('maxFramerate' in encodingParam) {
                  if (!(parseFloat(encodingParam.maxFramerate) >= 0)) {
                    throw new RangeError('max_framerate must be >= 0.0');
                  }
                }
              });
            }
            var transceiver = origAddTransceiver.apply(this, arguments);
            if (shouldPerformCheck) {
              // Check if the init options were applied. If not we do this in an
              // asynchronous way and save the promise reference in a global object.
              // This is an ugly hack, but at the same time is way more robust than
              // checking the sender parameters before and after the createOffer
              // Also note that after the createoffer we are not 100% sure that
              // the params were asynchronously applied so we might miss the
              // opportunity to recreate offer.
              var sender = transceiver.sender;
              var params = sender.getParameters();
              if (!('encodings' in params) ||
              // Avoid being fooled by patched getParameters() below.
              params.encodings.length === 1 && Object.keys(params.encodings[0]).length === 0) {
                params.encodings = initParameters.sendEncodings;
                sender.sendEncodings = initParameters.sendEncodings;
                this.setParametersPromises.push(sender.setParameters(params).then(function () {
                  delete sender.sendEncodings;
                })["catch"](function () {
                  delete sender.sendEncodings;
                }));
              }
            }
            return transceiver;
          };
        }
      }
      function shimGetParameters(window) {
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCRtpSender)) {
          return;
        }
        var origGetParameters = window.RTCRtpSender.prototype.getParameters;
        if (origGetParameters) {
          window.RTCRtpSender.prototype.getParameters = function getParameters() {
            var params = origGetParameters.apply(this, arguments);
            if (!('encodings' in params)) {
              params.encodings = [].concat(this.sendEncodings || [{}]);
            }
            return params;
          };
        }
      }
      function shimCreateOffer(window) {
        // https://github.com/webrtcHacks/adapter/issues/998#issuecomment-516921647
        // Firefox ignores the init sendEncodings options passed to addTransceiver
        // https://bugzilla.mozilla.org/show_bug.cgi?id=1396918
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection)) {
          return;
        }
        var origCreateOffer = window.RTCPeerConnection.prototype.createOffer;
        window.RTCPeerConnection.prototype.createOffer = function createOffer() {
          var _this4 = this,
            _arguments2 = arguments;
          if (this.setParametersPromises && this.setParametersPromises.length) {
            return Promise.all(this.setParametersPromises).then(function () {
              return origCreateOffer.apply(_this4, _arguments2);
            })["finally"](function () {
              _this4.setParametersPromises = [];
            });
          }
          return origCreateOffer.apply(this, arguments);
        };
      }
      function shimCreateAnswer(window) {
        // https://github.com/webrtcHacks/adapter/issues/998#issuecomment-516921647
        // Firefox ignores the init sendEncodings options passed to addTransceiver
        // https://bugzilla.mozilla.org/show_bug.cgi?id=1396918
        if (!((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCPeerConnection)) {
          return;
        }
        var origCreateAnswer = window.RTCPeerConnection.prototype.createAnswer;
        window.RTCPeerConnection.prototype.createAnswer = function createAnswer() {
          var _this5 = this,
            _arguments3 = arguments;
          if (this.setParametersPromises && this.setParametersPromises.length) {
            return Promise.all(this.setParametersPromises).then(function () {
              return origCreateAnswer.apply(_this5, _arguments3);
            })["finally"](function () {
              _this5.setParametersPromises = [];
            });
          }
          return origCreateAnswer.apply(this, arguments);
        };
      }
    }, {
      "../utils": 11,
      "./getdisplaymedia": 8,
      "./getusermedia": 9
    }],
    8: [function (require, module, exports) {
      /*
       *  Copyright (c) 2018 The adapter.js project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      exports.shimGetDisplayMedia = shimGetDisplayMedia;
      function shimGetDisplayMedia(window, preferredMediaSource) {
        if (window.navigator.mediaDevices && 'getDisplayMedia' in window.navigator.mediaDevices) {
          return;
        }
        if (!window.navigator.mediaDevices) {
          return;
        }
        window.navigator.mediaDevices.getDisplayMedia = function getDisplayMedia(constraints) {
          if (!(constraints && constraints.video)) {
            var err = new DOMException('getDisplayMedia without video ' + 'constraints is undefined');
            err.name = 'NotFoundError';
            // from https://heycam.github.io/webidl/#idl-DOMException-error-names
            err.code = 8;
            return Promise.reject(err);
          }
          if (constraints.video === true) {
            constraints.video = {
              mediaSource: preferredMediaSource
            };
          } else {
            constraints.video.mediaSource = preferredMediaSource;
          }
          return window.navigator.mediaDevices.getUserMedia(constraints);
        };
      }
    }, {}],
    9: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      exports.shimGetUserMedia = shimGetUserMedia;
      var _utils = require('../utils');
      var utils = _interopRequireWildcard(_utils);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }
      function shimGetUserMedia(window, browserDetails) {
        var navigator = window && window.navigator;
        var MediaStreamTrack = window && window.MediaStreamTrack;
        navigator.getUserMedia = function (constraints, onSuccess, onError) {
          // Replace Firefox 44+'s deprecation warning with unprefixed version.
          utils.deprecated('navigator.getUserMedia', 'navigator.mediaDevices.getUserMedia');
          navigator.mediaDevices.getUserMedia(constraints).then(onSuccess, onError);
        };
        if (!(browserDetails.version > 55 && 'autoGainControl' in navigator.mediaDevices.getSupportedConstraints())) {
          var remap = function remap(obj, a, b) {
            if (a in obj && !(b in obj)) {
              obj[b] = obj[a];
              delete obj[a];
            }
          };
          var nativeGetUserMedia = navigator.mediaDevices.getUserMedia.bind(navigator.mediaDevices);
          navigator.mediaDevices.getUserMedia = function (c) {
            if ((typeof c === 'undefined' ? 'undefined' : _typeof(c)) === 'object' && _typeof(c.audio) === 'object') {
              c = JSON.parse(JSON.stringify(c));
              remap(c.audio, 'autoGainControl', 'mozAutoGainControl');
              remap(c.audio, 'noiseSuppression', 'mozNoiseSuppression');
            }
            return nativeGetUserMedia(c);
          };
          if (MediaStreamTrack && MediaStreamTrack.prototype.getSettings) {
            var nativeGetSettings = MediaStreamTrack.prototype.getSettings;
            MediaStreamTrack.prototype.getSettings = function () {
              var obj = nativeGetSettings.apply(this, arguments);
              remap(obj, 'mozAutoGainControl', 'autoGainControl');
              remap(obj, 'mozNoiseSuppression', 'noiseSuppression');
              return obj;
            };
          }
          if (MediaStreamTrack && MediaStreamTrack.prototype.applyConstraints) {
            var nativeApplyConstraints = MediaStreamTrack.prototype.applyConstraints;
            MediaStreamTrack.prototype.applyConstraints = function (c) {
              if (this.kind === 'audio' && (typeof c === 'undefined' ? 'undefined' : _typeof(c)) === 'object') {
                c = JSON.parse(JSON.stringify(c));
                remap(c, 'autoGainControl', 'mozAutoGainControl');
                remap(c, 'noiseSuppression', 'mozNoiseSuppression');
              }
              return nativeApplyConstraints.apply(this, [c]);
            };
          }
        }
      }
    }, {
      "../utils": 11
    }],
    10: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      exports.shimLocalStreamsAPI = shimLocalStreamsAPI;
      exports.shimRemoteStreamsAPI = shimRemoteStreamsAPI;
      exports.shimCallbacksAPI = shimCallbacksAPI;
      exports.shimGetUserMedia = shimGetUserMedia;
      exports.shimConstraints = shimConstraints;
      exports.shimRTCIceServerUrls = shimRTCIceServerUrls;
      exports.shimTrackEventTransceiver = shimTrackEventTransceiver;
      exports.shimCreateOfferLegacy = shimCreateOfferLegacy;
      exports.shimAudioContext = shimAudioContext;
      var _utils = require('../utils');
      var utils = _interopRequireWildcard(_utils);
      function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
          return obj;
        } else {
          var newObj = {};
          if (obj != null) {
            for (var key in obj) {
              if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
            }
          }
          newObj["default"] = obj;
          return newObj;
        }
      }
      function shimLocalStreamsAPI(window) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) !== 'object' || !window.RTCPeerConnection) {
          return;
        }
        if (!('getLocalStreams' in window.RTCPeerConnection.prototype)) {
          window.RTCPeerConnection.prototype.getLocalStreams = function getLocalStreams() {
            if (!this._localStreams) {
              this._localStreams = [];
            }
            return this._localStreams;
          };
        }
        if (!('addStream' in window.RTCPeerConnection.prototype)) {
          var _addTrack = window.RTCPeerConnection.prototype.addTrack;
          window.RTCPeerConnection.prototype.addStream = function addStream(stream) {
            var _this = this;
            if (!this._localStreams) {
              this._localStreams = [];
            }
            if (!this._localStreams.includes(stream)) {
              this._localStreams.push(stream);
            }
            // Try to emulate Chrome's behaviour of adding in audio-video order.
            // Safari orders by track id.
            stream.getAudioTracks().forEach(function (track) {
              return _addTrack.call(_this, track, stream);
            });
            stream.getVideoTracks().forEach(function (track) {
              return _addTrack.call(_this, track, stream);
            });
          };
          window.RTCPeerConnection.prototype.addTrack = function addTrack(track) {
            var _this2 = this;
            for (var _len = arguments.length, streams = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
              streams[_key - 1] = arguments[_key];
            }
            if (streams) {
              streams.forEach(function (stream) {
                if (!_this2._localStreams) {
                  _this2._localStreams = [stream];
                } else if (!_this2._localStreams.includes(stream)) {
                  _this2._localStreams.push(stream);
                }
              });
            }
            return _addTrack.apply(this, arguments);
          };
        }
        if (!('removeStream' in window.RTCPeerConnection.prototype)) {
          window.RTCPeerConnection.prototype.removeStream = function removeStream(stream) {
            var _this3 = this;
            if (!this._localStreams) {
              this._localStreams = [];
            }
            var index = this._localStreams.indexOf(stream);
            if (index === -1) {
              return;
            }
            this._localStreams.splice(index, 1);
            var tracks = stream.getTracks();
            this.getSenders().forEach(function (sender) {
              if (tracks.includes(sender.track)) {
                _this3.removeTrack(sender);
              }
            });
          };
        }
      }
      function shimRemoteStreamsAPI(window) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) !== 'object' || !window.RTCPeerConnection) {
          return;
        }
        if (!('getRemoteStreams' in window.RTCPeerConnection.prototype)) {
          window.RTCPeerConnection.prototype.getRemoteStreams = function getRemoteStreams() {
            return this._remoteStreams ? this._remoteStreams : [];
          };
        }
        if (!('onaddstream' in window.RTCPeerConnection.prototype)) {
          Object.defineProperty(window.RTCPeerConnection.prototype, 'onaddstream', {
            get: function get() {
              return this._onaddstream;
            },
            set: function set(f) {
              var _this4 = this;
              if (this._onaddstream) {
                this.removeEventListener('addstream', this._onaddstream);
                this.removeEventListener('track', this._onaddstreampoly);
              }
              this.addEventListener('addstream', this._onaddstream = f);
              this.addEventListener('track', this._onaddstreampoly = function (e) {
                e.streams.forEach(function (stream) {
                  if (!_this4._remoteStreams) {
                    _this4._remoteStreams = [];
                  }
                  if (_this4._remoteStreams.includes(stream)) {
                    return;
                  }
                  _this4._remoteStreams.push(stream);
                  var event = new Event('addstream');
                  event.stream = stream;
                  _this4.dispatchEvent(event);
                });
              });
            }
          });
          var origSetRemoteDescription = window.RTCPeerConnection.prototype.setRemoteDescription;
          window.RTCPeerConnection.prototype.setRemoteDescription = function setRemoteDescription() {
            var pc = this;
            if (!this._onaddstreampoly) {
              this.addEventListener('track', this._onaddstreampoly = function (e) {
                e.streams.forEach(function (stream) {
                  if (!pc._remoteStreams) {
                    pc._remoteStreams = [];
                  }
                  if (pc._remoteStreams.indexOf(stream) >= 0) {
                    return;
                  }
                  pc._remoteStreams.push(stream);
                  var event = new Event('addstream');
                  event.stream = stream;
                  pc.dispatchEvent(event);
                });
              });
            }
            return origSetRemoteDescription.apply(pc, arguments);
          };
        }
      }
      function shimCallbacksAPI(window) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) !== 'object' || !window.RTCPeerConnection) {
          return;
        }
        var prototype = window.RTCPeerConnection.prototype;
        var origCreateOffer = prototype.createOffer;
        var origCreateAnswer = prototype.createAnswer;
        var setLocalDescription = prototype.setLocalDescription;
        var setRemoteDescription = prototype.setRemoteDescription;
        var addIceCandidate = prototype.addIceCandidate;
        prototype.createOffer = function createOffer(successCallback, failureCallback) {
          var options = arguments.length >= 2 ? arguments[2] : arguments[0];
          var promise = origCreateOffer.apply(this, [options]);
          if (!failureCallback) {
            return promise;
          }
          promise.then(successCallback, failureCallback);
          return Promise.resolve();
        };
        prototype.createAnswer = function createAnswer(successCallback, failureCallback) {
          var options = arguments.length >= 2 ? arguments[2] : arguments[0];
          var promise = origCreateAnswer.apply(this, [options]);
          if (!failureCallback) {
            return promise;
          }
          promise.then(successCallback, failureCallback);
          return Promise.resolve();
        };
        var withCallback = function withCallback(description, successCallback, failureCallback) {
          var promise = setLocalDescription.apply(this, [description]);
          if (!failureCallback) {
            return promise;
          }
          promise.then(successCallback, failureCallback);
          return Promise.resolve();
        };
        prototype.setLocalDescription = withCallback;
        withCallback = function withCallback(description, successCallback, failureCallback) {
          var promise = setRemoteDescription.apply(this, [description]);
          if (!failureCallback) {
            return promise;
          }
          promise.then(successCallback, failureCallback);
          return Promise.resolve();
        };
        prototype.setRemoteDescription = withCallback;
        withCallback = function withCallback(candidate, successCallback, failureCallback) {
          var promise = addIceCandidate.apply(this, [candidate]);
          if (!failureCallback) {
            return promise;
          }
          promise.then(successCallback, failureCallback);
          return Promise.resolve();
        };
        prototype.addIceCandidate = withCallback;
      }
      function shimGetUserMedia(window) {
        var navigator = window && window.navigator;
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
          // shim not needed in Safari 12.1
          var mediaDevices = navigator.mediaDevices;
          var _getUserMedia = mediaDevices.getUserMedia.bind(mediaDevices);
          navigator.mediaDevices.getUserMedia = function (constraints) {
            return _getUserMedia(shimConstraints(constraints));
          };
        }
        if (!navigator.getUserMedia && navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
          navigator.getUserMedia = function getUserMedia(constraints, cb, errcb) {
            navigator.mediaDevices.getUserMedia(constraints).then(cb, errcb);
          }.bind(navigator);
        }
      }
      function shimConstraints(constraints) {
        if (constraints && constraints.video !== undefined) {
          return Object.assign({}, constraints, {
            video: utils.compactObject(constraints.video)
          });
        }
        return constraints;
      }
      function shimRTCIceServerUrls(window) {
        if (!window.RTCPeerConnection) {
          return;
        }
        // migrate from non-spec RTCIceServer.url to RTCIceServer.urls
        var OrigPeerConnection = window.RTCPeerConnection;
        window.RTCPeerConnection = function RTCPeerConnection(pcConfig, pcConstraints) {
          if (pcConfig && pcConfig.iceServers) {
            var newIceServers = [];
            for (var i = 0; i < pcConfig.iceServers.length; i++) {
              var server = pcConfig.iceServers[i];
              if (!server.hasOwnProperty('urls') && server.hasOwnProperty('url')) {
                utils.deprecated('RTCIceServer.url', 'RTCIceServer.urls');
                server = JSON.parse(JSON.stringify(server));
                server.urls = server.url;
                delete server.url;
                newIceServers.push(server);
              } else {
                newIceServers.push(pcConfig.iceServers[i]);
              }
            }
            pcConfig.iceServers = newIceServers;
          }
          return new OrigPeerConnection(pcConfig, pcConstraints);
        };
        window.RTCPeerConnection.prototype = OrigPeerConnection.prototype;
        // wrap static methods. Currently just generateCertificate.
        if ('generateCertificate' in OrigPeerConnection) {
          Object.defineProperty(window.RTCPeerConnection, 'generateCertificate', {
            get: function get() {
              return OrigPeerConnection.generateCertificate;
            }
          });
        }
      }
      function shimTrackEventTransceiver(window) {
        // Add event.transceiver member over deprecated event.receiver
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object' && window.RTCTrackEvent && 'receiver' in window.RTCTrackEvent.prototype && !('transceiver' in window.RTCTrackEvent.prototype)) {
          Object.defineProperty(window.RTCTrackEvent.prototype, 'transceiver', {
            get: function get() {
              return {
                receiver: this.receiver
              };
            }
          });
        }
      }
      function shimCreateOfferLegacy(window) {
        var origCreateOffer = window.RTCPeerConnection.prototype.createOffer;
        window.RTCPeerConnection.prototype.createOffer = function createOffer(offerOptions) {
          if (offerOptions) {
            if (typeof offerOptions.offerToReceiveAudio !== 'undefined') {
              // support bit values
              offerOptions.offerToReceiveAudio = !!offerOptions.offerToReceiveAudio;
            }
            var audioTransceiver = this.getTransceivers().find(function (transceiver) {
              return transceiver.receiver.track.kind === 'audio';
            });
            if (offerOptions.offerToReceiveAudio === false && audioTransceiver) {
              if (audioTransceiver.direction === 'sendrecv') {
                if (audioTransceiver.setDirection) {
                  audioTransceiver.setDirection('sendonly');
                } else {
                  audioTransceiver.direction = 'sendonly';
                }
              } else if (audioTransceiver.direction === 'recvonly') {
                if (audioTransceiver.setDirection) {
                  audioTransceiver.setDirection('inactive');
                } else {
                  audioTransceiver.direction = 'inactive';
                }
              }
            } else if (offerOptions.offerToReceiveAudio === true && !audioTransceiver) {
              this.addTransceiver('audio');
            }
            if (typeof offerOptions.offerToReceiveVideo !== 'undefined') {
              // support bit values
              offerOptions.offerToReceiveVideo = !!offerOptions.offerToReceiveVideo;
            }
            var videoTransceiver = this.getTransceivers().find(function (transceiver) {
              return transceiver.receiver.track.kind === 'video';
            });
            if (offerOptions.offerToReceiveVideo === false && videoTransceiver) {
              if (videoTransceiver.direction === 'sendrecv') {
                if (videoTransceiver.setDirection) {
                  videoTransceiver.setDirection('sendonly');
                } else {
                  videoTransceiver.direction = 'sendonly';
                }
              } else if (videoTransceiver.direction === 'recvonly') {
                if (videoTransceiver.setDirection) {
                  videoTransceiver.setDirection('inactive');
                } else {
                  videoTransceiver.direction = 'inactive';
                }
              }
            } else if (offerOptions.offerToReceiveVideo === true && !videoTransceiver) {
              this.addTransceiver('video');
            }
          }
          return origCreateOffer.apply(this, arguments);
        };
      }
      function shimAudioContext(window) {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) !== 'object' || window.AudioContext) {
          return;
        }
        window.AudioContext = window.webkitAudioContext;
      }
    }, {
      "../utils": 11
    }],
    11: [function (require, module, exports) {
      /*
       *  Copyright (c) 2016 The WebRTC project authors. All Rights Reserved.
       *
       *  Use of this source code is governed by a BSD-style license
       *  that can be found in the LICENSE file in the root of the source
       *  tree.
       */
      /* eslint-env node */
      'use strict';

      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      exports.extractVersion = extractVersion;
      exports.wrapPeerConnectionEvent = wrapPeerConnectionEvent;
      exports.disableLog = disableLog;
      exports.disableWarnings = disableWarnings;
      exports.log = log;
      exports.deprecated = deprecated;
      exports.detectBrowser = detectBrowser;
      exports.compactObject = compactObject;
      exports.walkStats = walkStats;
      exports.filterStats = filterStats;
      function _defineProperty(obj, key, value) {
        if (key in obj) {
          Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
          });
        } else {
          obj[key] = value;
        }
        return obj;
      }
      var logDisabled_ = true;
      var deprecationWarnings_ = true;

      /**
       * Extract browser version out of the provided user agent string.
       *
       * @param {!string} uastring userAgent string.
       * @param {!string} expr Regular expression used as match criteria.
       * @param {!number} pos position in the version string to be returned.
       * @return {!number} browser version.
       */
      function extractVersion(uastring, expr, pos) {
        var match = uastring.match(expr);
        return match && match.length >= pos && parseInt(match[pos], 10);
      }

      // Wraps the peerconnection event eventNameToWrap in a function
      // which returns the modified event object (or false to prevent
      // the event).
      function wrapPeerConnectionEvent(window, eventNameToWrap, wrapper) {
        if (!window.RTCPeerConnection) {
          return;
        }
        var proto = window.RTCPeerConnection.prototype;
        var nativeAddEventListener = proto.addEventListener;
        proto.addEventListener = function (nativeEventName, cb) {
          if (nativeEventName !== eventNameToWrap) {
            return nativeAddEventListener.apply(this, arguments);
          }
          var wrappedCallback = function wrappedCallback(e) {
            var modifiedEvent = wrapper(e);
            if (modifiedEvent) {
              if (cb.handleEvent) {
                cb.handleEvent(modifiedEvent);
              } else {
                cb(modifiedEvent);
              }
            }
          };
          this._eventMap = this._eventMap || {};
          if (!this._eventMap[eventNameToWrap]) {
            this._eventMap[eventNameToWrap] = new Map();
          }
          this._eventMap[eventNameToWrap].set(cb, wrappedCallback);
          return nativeAddEventListener.apply(this, [nativeEventName, wrappedCallback]);
        };
        var nativeRemoveEventListener = proto.removeEventListener;
        proto.removeEventListener = function (nativeEventName, cb) {
          if (nativeEventName !== eventNameToWrap || !this._eventMap || !this._eventMap[eventNameToWrap]) {
            return nativeRemoveEventListener.apply(this, arguments);
          }
          if (!this._eventMap[eventNameToWrap].has(cb)) {
            return nativeRemoveEventListener.apply(this, arguments);
          }
          var unwrappedCb = this._eventMap[eventNameToWrap].get(cb);
          this._eventMap[eventNameToWrap]["delete"](cb);
          if (this._eventMap[eventNameToWrap].size === 0) {
            delete this._eventMap[eventNameToWrap];
          }
          if (Object.keys(this._eventMap).length === 0) {
            delete this._eventMap;
          }
          return nativeRemoveEventListener.apply(this, [nativeEventName, unwrappedCb]);
        };
        Object.defineProperty(proto, 'on' + eventNameToWrap, {
          get: function get() {
            return this['_on' + eventNameToWrap];
          },
          set: function set(cb) {
            if (this['_on' + eventNameToWrap]) {
              this.removeEventListener(eventNameToWrap, this['_on' + eventNameToWrap]);
              delete this['_on' + eventNameToWrap];
            }
            if (cb) {
              this.addEventListener(eventNameToWrap, this['_on' + eventNameToWrap] = cb);
            }
          },
          enumerable: true,
          configurable: true
        });
      }
      function disableLog(bool) {
        if (typeof bool !== 'boolean') {
          return new Error('Argument type: ' + (typeof bool === 'undefined' ? 'undefined' : _typeof(bool)) + '. Please use a boolean.');
        }
        logDisabled_ = bool;
        return bool ? 'adapter.js logging disabled' : 'adapter.js logging enabled';
      }

      /**
       * Disable or enable deprecation warnings
       * @param {!boolean} bool set to true to disable warnings.
       */
      function disableWarnings(bool) {
        if (typeof bool !== 'boolean') {
          return new Error('Argument type: ' + (typeof bool === 'undefined' ? 'undefined' : _typeof(bool)) + '. Please use a boolean.');
        }
        deprecationWarnings_ = !bool;
        return 'adapter.js deprecation warnings ' + (bool ? 'disabled' : 'enabled');
      }
      function log() {
        if ((typeof window === 'undefined' ? 'undefined' : _typeof(window)) === 'object') {
          if (logDisabled_) {
            return;
          }
          if (typeof console !== 'undefined' && typeof console.log === 'function') {
            console.log.apply(console, arguments);
          }
        }
      }

      /**
       * Shows a deprecation warning suggesting the modern and spec-compatible API.
       */
      function deprecated(oldMethod, newMethod) {
        if (!deprecationWarnings_) {
          return;
        }
        console.warn(oldMethod + ' is deprecated, please use ' + newMethod + ' instead.');
      }

      /**
       * Browser detector.
       *
       * @return {object} result containing browser and version
       *     properties.
       */
      function detectBrowser(window) {
        // Returned result object.
        var result = {
          browser: null,
          version: null
        };

        // Fail early if it's not a browser
        if (typeof window === 'undefined' || !window.navigator) {
          result.browser = 'Not a browser.';
          return result;
        }
        var navigator = window.navigator;
        if (navigator.mozGetUserMedia) {
          // Firefox.
          result.browser = 'firefox';
          result.version = extractVersion(navigator.userAgent, /Firefox\/(\d+)\./, 1);
        } else if (navigator.webkitGetUserMedia || window.isSecureContext === false && window.webkitRTCPeerConnection && !window.RTCIceGatherer) {
          // Chrome, Chromium, Webview, Opera.
          // Version matches Chrome/WebRTC version.
          // Chrome 74 removed webkitGetUserMedia on http as well so we need the
          // more complicated fallback to webkitRTCPeerConnection.
          result.browser = 'chrome';
          result.version = extractVersion(navigator.userAgent, /Chrom(e|ium)\/(\d+)\./, 2);
        } else if (window.RTCPeerConnection && navigator.userAgent.match(/AppleWebKit\/(\d+)\./)) {
          // Safari.
          result.browser = 'safari';
          result.version = extractVersion(navigator.userAgent, /AppleWebKit\/(\d+)\./, 1);
          result.supportsUnifiedPlan = window.RTCRtpTransceiver && 'currentDirection' in window.RTCRtpTransceiver.prototype;
        } else {
          // Default fallthrough: not supported.
          result.browser = 'Not a supported browser.';
          return result;
        }
        return result;
      }

      /**
       * Checks if something is an object.
       *
       * @param {*} val The something you want to check.
       * @return true if val is an object, false otherwise.
       */
      function isObject(val) {
        return Object.prototype.toString.call(val) === '[object Object]';
      }

      /**
       * Remove all empty objects and undefined values
       * from a nested object -- an enhanced and vanilla version
       * of Lodash's `compact`.
       */
      function compactObject(data) {
        if (!isObject(data)) {
          return data;
        }
        return Object.keys(data).reduce(function (accumulator, key) {
          var isObj = isObject(data[key]);
          var value = isObj ? compactObject(data[key]) : data[key];
          var isEmptyObject = isObj && !Object.keys(value).length;
          if (value === undefined || isEmptyObject) {
            return accumulator;
          }
          return Object.assign(accumulator, _defineProperty({}, key, value));
        }, {});
      }

      /* iterates the stats graph recursively. */
      function walkStats(stats, base, resultSet) {
        if (!base || resultSet.has(base.id)) {
          return;
        }
        resultSet.set(base.id, base);
        Object.keys(base).forEach(function (name) {
          if (name.endsWith('Id')) {
            walkStats(stats, stats.get(base[name]), resultSet);
          } else if (name.endsWith('Ids')) {
            base[name].forEach(function (id) {
              walkStats(stats, stats.get(id), resultSet);
            });
          }
        });
      }

      /* filter getStats for a sender/receiver track. */
      function filterStats(result, track, outbound) {
        var streamStatsType = outbound ? 'outbound-rtp' : 'inbound-rtp';
        var filteredResult = new Map();
        if (track === null) {
          return filteredResult;
        }
        var trackStats = [];
        result.forEach(function (value) {
          if (value.type === 'track' && value.trackIdentifier === track.id) {
            trackStats.push(value);
          }
        });
        trackStats.forEach(function (trackStat) {
          result.forEach(function (stats) {
            if (stats.type === streamStatsType && stats.trackId === trackStat.id) {
              walkStats(result, stats, filteredResult);
            }
          });
        });
        return filteredResult;
      }
    }, {}],
    12: [function (require, module, exports) {
      /* eslint-env node */
      'use strict';

      // SDP helpers.
      var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (obj) {
        return _typeof2(obj);
      } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
      };
      var SDPUtils = {};

      // Generate an alphanumeric identifier for cname or mids.
      // TODO: use UUIDs instead? https://gist.github.com/jed/982883
      SDPUtils.generateIdentifier = function () {
        return Math.random().toString(36).substr(2, 10);
      };

      // The RTCP CNAME used by all peerconnections from the same JS.
      SDPUtils.localCName = SDPUtils.generateIdentifier();

      // Splits SDP into lines, dealing with both CRLF and LF.
      SDPUtils.splitLines = function (blob) {
        return blob.trim().split('\n').map(function (line) {
          return line.trim();
        });
      };
      // Splits SDP into sessionpart and mediasections. Ensures CRLF.
      SDPUtils.splitSections = function (blob) {
        var parts = blob.split('\nm=');
        return parts.map(function (part, index) {
          return (index > 0 ? 'm=' + part : part).trim() + '\r\n';
        });
      };

      // returns the session description.
      SDPUtils.getDescription = function (blob) {
        var sections = SDPUtils.splitSections(blob);
        return sections && sections[0];
      };

      // returns the individual media sections.
      SDPUtils.getMediaSections = function (blob) {
        var sections = SDPUtils.splitSections(blob);
        sections.shift();
        return sections;
      };

      // Returns lines that start with a certain prefix.
      SDPUtils.matchPrefix = function (blob, prefix) {
        return SDPUtils.splitLines(blob).filter(function (line) {
          return line.indexOf(prefix) === 0;
        });
      };

      // Parses an ICE candidate line. Sample input:
      // candidate:702786350 2 udp 41819902 8.8.8.8 60769 typ relay raddr 8.8.8.8
      // rport 55996"
      SDPUtils.parseCandidate = function (line) {
        var parts = void 0;
        // Parse both variants.
        if (line.indexOf('a=candidate:') === 0) {
          parts = line.substring(12).split(' ');
        } else {
          parts = line.substring(10).split(' ');
        }
        var candidate = {
          foundation: parts[0],
          component: {
            1: 'rtp',
            2: 'rtcp'
          }[parts[1]],
          protocol: parts[2].toLowerCase(),
          priority: parseInt(parts[3], 10),
          ip: parts[4],
          address: parts[4],
          // address is an alias for ip.
          port: parseInt(parts[5], 10),
          // skip parts[6] == 'typ'
          type: parts[7]
        };
        for (var i = 8; i < parts.length; i += 2) {
          switch (parts[i]) {
            case 'raddr':
              candidate.relatedAddress = parts[i + 1];
              break;
            case 'rport':
              candidate.relatedPort = parseInt(parts[i + 1], 10);
              break;
            case 'tcptype':
              candidate.tcpType = parts[i + 1];
              break;
            case 'ufrag':
              candidate.ufrag = parts[i + 1]; // for backward compatibility.
              candidate.usernameFragment = parts[i + 1];
              break;
            default:
              // extension handling, in particular ufrag. Don't overwrite.
              if (candidate[parts[i]] === undefined) {
                candidate[parts[i]] = parts[i + 1];
              }
              break;
          }
        }
        return candidate;
      };

      // Translates a candidate object into SDP candidate attribute.
      SDPUtils.writeCandidate = function (candidate) {
        var sdp = [];
        sdp.push(candidate.foundation);
        var component = candidate.component;
        if (component === 'rtp') {
          sdp.push(1);
        } else if (component === 'rtcp') {
          sdp.push(2);
        } else {
          sdp.push(component);
        }
        sdp.push(candidate.protocol.toUpperCase());
        sdp.push(candidate.priority);
        sdp.push(candidate.address || candidate.ip);
        sdp.push(candidate.port);
        var type = candidate.type;
        sdp.push('typ');
        sdp.push(type);
        if (type !== 'host' && candidate.relatedAddress && candidate.relatedPort) {
          sdp.push('raddr');
          sdp.push(candidate.relatedAddress);
          sdp.push('rport');
          sdp.push(candidate.relatedPort);
        }
        if (candidate.tcpType && candidate.protocol.toLowerCase() === 'tcp') {
          sdp.push('tcptype');
          sdp.push(candidate.tcpType);
        }
        if (candidate.usernameFragment || candidate.ufrag) {
          sdp.push('ufrag');
          sdp.push(candidate.usernameFragment || candidate.ufrag);
        }
        return 'candidate:' + sdp.join(' ');
      };

      // Parses an ice-options line, returns an array of option tags.
      // a=ice-options:foo bar
      SDPUtils.parseIceOptions = function (line) {
        return line.substr(14).split(' ');
      };

      // Parses an rtpmap line, returns RTCRtpCoddecParameters. Sample input:
      // a=rtpmap:111 opus/48000/2
      SDPUtils.parseRtpMap = function (line) {
        var parts = line.substr(9).split(' ');
        var parsed = {
          payloadType: parseInt(parts.shift(), 10) // was: id
        };

        parts = parts[0].split('/');
        parsed.name = parts[0];
        parsed.clockRate = parseInt(parts[1], 10); // was: clockrate
        parsed.channels = parts.length === 3 ? parseInt(parts[2], 10) : 1;
        // legacy alias, got renamed back to channels in ORTC.
        parsed.numChannels = parsed.channels;
        return parsed;
      };

      // Generate an a=rtpmap line from RTCRtpCodecCapability or
      // RTCRtpCodecParameters.
      SDPUtils.writeRtpMap = function (codec) {
        var pt = codec.payloadType;
        if (codec.preferredPayloadType !== undefined) {
          pt = codec.preferredPayloadType;
        }
        var channels = codec.channels || codec.numChannels || 1;
        return 'a=rtpmap:' + pt + ' ' + codec.name + '/' + codec.clockRate + (channels !== 1 ? '/' + channels : '') + '\r\n';
      };

      // Parses an a=extmap line (headerextension from RFC 5285). Sample input:
      // a=extmap:2 urn:ietf:params:rtp-hdrext:toffset
      // a=extmap:2/sendonly urn:ietf:params:rtp-hdrext:toffset
      SDPUtils.parseExtmap = function (line) {
        var parts = line.substr(9).split(' ');
        return {
          id: parseInt(parts[0], 10),
          direction: parts[0].indexOf('/') > 0 ? parts[0].split('/')[1] : 'sendrecv',
          uri: parts[1]
        };
      };

      // Generates a=extmap line from RTCRtpHeaderExtensionParameters or
      // RTCRtpHeaderExtension.
      SDPUtils.writeExtmap = function (headerExtension) {
        return 'a=extmap:' + (headerExtension.id || headerExtension.preferredId) + (headerExtension.direction && headerExtension.direction !== 'sendrecv' ? '/' + headerExtension.direction : '') + ' ' + headerExtension.uri + '\r\n';
      };

      // Parses an ftmp line, returns dictionary. Sample input:
      // a=fmtp:96 vbr=on;cng=on
      // Also deals with vbr=on; cng=on
      SDPUtils.parseFmtp = function (line) {
        var parsed = {};
        var kv = void 0;
        var parts = line.substr(line.indexOf(' ') + 1).split(';');
        for (var j = 0; j < parts.length; j++) {
          kv = parts[j].trim().split('=');
          parsed[kv[0].trim()] = kv[1];
        }
        return parsed;
      };

      // Generates an a=ftmp line from RTCRtpCodecCapability or RTCRtpCodecParameters.
      SDPUtils.writeFmtp = function (codec) {
        var line = '';
        var pt = codec.payloadType;
        if (codec.preferredPayloadType !== undefined) {
          pt = codec.preferredPayloadType;
        }
        if (codec.parameters && Object.keys(codec.parameters).length) {
          var params = [];
          Object.keys(codec.parameters).forEach(function (param) {
            if (codec.parameters[param]) {
              params.push(param + '=' + codec.parameters[param]);
            } else {
              params.push(param);
            }
          });
          line += 'a=fmtp:' + pt + ' ' + params.join(';') + '\r\n';
        }
        return line;
      };

      // Parses an rtcp-fb line, returns RTCPRtcpFeedback object. Sample input:
      // a=rtcp-fb:98 nack rpsi
      SDPUtils.parseRtcpFb = function (line) {
        var parts = line.substr(line.indexOf(' ') + 1).split(' ');
        return {
          type: parts.shift(),
          parameter: parts.join(' ')
        };
      };
      // Generate a=rtcp-fb lines from RTCRtpCodecCapability or RTCRtpCodecParameters.
      SDPUtils.writeRtcpFb = function (codec) {
        var lines = '';
        var pt = codec.payloadType;
        if (codec.preferredPayloadType !== undefined) {
          pt = codec.preferredPayloadType;
        }
        if (codec.rtcpFeedback && codec.rtcpFeedback.length) {
          // FIXME: special handling for trr-int?
          codec.rtcpFeedback.forEach(function (fb) {
            lines += 'a=rtcp-fb:' + pt + ' ' + fb.type + (fb.parameter && fb.parameter.length ? ' ' + fb.parameter : '') + '\r\n';
          });
        }
        return lines;
      };

      // Parses an RFC 5576 ssrc media attribute. Sample input:
      // a=ssrc:3735928559 cname:something
      SDPUtils.parseSsrcMedia = function (line) {
        var sp = line.indexOf(' ');
        var parts = {
          ssrc: parseInt(line.substr(7, sp - 7), 10)
        };
        var colon = line.indexOf(':', sp);
        if (colon > -1) {
          parts.attribute = line.substr(sp + 1, colon - sp - 1);
          parts.value = line.substr(colon + 1);
        } else {
          parts.attribute = line.substr(sp + 1);
        }
        return parts;
      };
      SDPUtils.parseSsrcGroup = function (line) {
        var parts = line.substr(13).split(' ');
        return {
          semantics: parts.shift(),
          ssrcs: parts.map(function (ssrc) {
            return parseInt(ssrc, 10);
          })
        };
      };

      // Extracts the MID (RFC 5888) from a media section.
      // returns the MID or undefined if no mid line was found.
      SDPUtils.getMid = function (mediaSection) {
        var mid = SDPUtils.matchPrefix(mediaSection, 'a=mid:')[0];
        if (mid) {
          return mid.substr(6);
        }
      };
      SDPUtils.parseFingerprint = function (line) {
        var parts = line.substr(14).split(' ');
        return {
          algorithm: parts[0].toLowerCase(),
          // algorithm is case-sensitive in Edge.
          value: parts[1]
        };
      };

      // Extracts DTLS parameters from SDP media section or sessionpart.
      // FIXME: for consistency with other functions this should only
      //   get the fingerprint line as input. See also getIceParameters.
      SDPUtils.getDtlsParameters = function (mediaSection, sessionpart) {
        var lines = SDPUtils.matchPrefix(mediaSection + sessionpart, 'a=fingerprint:');
        // Note: a=setup line is ignored since we use the 'auto' role.
        // Note2: 'algorithm' is not case sensitive except in Edge.
        return {
          role: 'auto',
          fingerprints: lines.map(SDPUtils.parseFingerprint)
        };
      };

      // Serializes DTLS parameters to SDP.
      SDPUtils.writeDtlsParameters = function (params, setupType) {
        var sdp = 'a=setup:' + setupType + '\r\n';
        params.fingerprints.forEach(function (fp) {
          sdp += 'a=fingerprint:' + fp.algorithm + ' ' + fp.value + '\r\n';
        });
        return sdp;
      };

      // Parses a=crypto lines into
      //   https://rawgit.com/aboba/edgertc/master/msortc-rs4.html#dictionary-rtcsrtpsdesparameters-members
      SDPUtils.parseCryptoLine = function (line) {
        var parts = line.substr(9).split(' ');
        return {
          tag: parseInt(parts[0], 10),
          cryptoSuite: parts[1],
          keyParams: parts[2],
          sessionParams: parts.slice(3)
        };
      };
      SDPUtils.writeCryptoLine = function (parameters) {
        return 'a=crypto:' + parameters.tag + ' ' + parameters.cryptoSuite + ' ' + (_typeof(parameters.keyParams) === 'object' ? SDPUtils.writeCryptoKeyParams(parameters.keyParams) : parameters.keyParams) + (parameters.sessionParams ? ' ' + parameters.sessionParams.join(' ') : '') + '\r\n';
      };

      // Parses the crypto key parameters into
      //   https://rawgit.com/aboba/edgertc/master/msortc-rs4.html#rtcsrtpkeyparam*
      SDPUtils.parseCryptoKeyParams = function (keyParams) {
        if (keyParams.indexOf('inline:') !== 0) {
          return null;
        }
        var parts = keyParams.substr(7).split('|');
        return {
          keyMethod: 'inline',
          keySalt: parts[0],
          lifeTime: parts[1],
          mkiValue: parts[2] ? parts[2].split(':')[0] : undefined,
          mkiLength: parts[2] ? parts[2].split(':')[1] : undefined
        };
      };
      SDPUtils.writeCryptoKeyParams = function (keyParams) {
        return keyParams.keyMethod + ':' + keyParams.keySalt + (keyParams.lifeTime ? '|' + keyParams.lifeTime : '') + (keyParams.mkiValue && keyParams.mkiLength ? '|' + keyParams.mkiValue + ':' + keyParams.mkiLength : '');
      };

      // Extracts all SDES parameters.
      SDPUtils.getCryptoParameters = function (mediaSection, sessionpart) {
        var lines = SDPUtils.matchPrefix(mediaSection + sessionpart, 'a=crypto:');
        return lines.map(SDPUtils.parseCryptoLine);
      };

      // Parses ICE information from SDP media section or sessionpart.
      // FIXME: for consistency with other functions this should only
      //   get the ice-ufrag and ice-pwd lines as input.
      SDPUtils.getIceParameters = function (mediaSection, sessionpart) {
        var ufrag = SDPUtils.matchPrefix(mediaSection + sessionpart, 'a=ice-ufrag:')[0];
        var pwd = SDPUtils.matchPrefix(mediaSection + sessionpart, 'a=ice-pwd:')[0];
        if (!(ufrag && pwd)) {
          return null;
        }
        return {
          usernameFragment: ufrag.substr(12),
          password: pwd.substr(10)
        };
      };

      // Serializes ICE parameters to SDP.
      SDPUtils.writeIceParameters = function (params) {
        var sdp = 'a=ice-ufrag:' + params.usernameFragment + '\r\n' + 'a=ice-pwd:' + params.password + '\r\n';
        if (params.iceLite) {
          sdp += 'a=ice-lite\r\n';
        }
        return sdp;
      };

      // Parses the SDP media section and returns RTCRtpParameters.
      SDPUtils.parseRtpParameters = function (mediaSection) {
        var description = {
          codecs: [],
          headerExtensions: [],
          fecMechanisms: [],
          rtcp: []
        };
        var lines = SDPUtils.splitLines(mediaSection);
        var mline = lines[0].split(' ');
        for (var i = 3; i < mline.length; i++) {
          // find all codecs from mline[3..]
          var pt = mline[i];
          var rtpmapline = SDPUtils.matchPrefix(mediaSection, 'a=rtpmap:' + pt + ' ')[0];
          if (rtpmapline) {
            var codec = SDPUtils.parseRtpMap(rtpmapline);
            var fmtps = SDPUtils.matchPrefix(mediaSection, 'a=fmtp:' + pt + ' ');
            // Only the first a=fmtp:<pt> is considered.
            codec.parameters = fmtps.length ? SDPUtils.parseFmtp(fmtps[0]) : {};
            codec.rtcpFeedback = SDPUtils.matchPrefix(mediaSection, 'a=rtcp-fb:' + pt + ' ').map(SDPUtils.parseRtcpFb);
            description.codecs.push(codec);
            // parse FEC mechanisms from rtpmap lines.
            switch (codec.name.toUpperCase()) {
              case 'RED':
              case 'ULPFEC':
                description.fecMechanisms.push(codec.name.toUpperCase());
                break;
              default:
                // only RED and ULPFEC are recognized as FEC mechanisms.
                break;
            }
          }
        }
        SDPUtils.matchPrefix(mediaSection, 'a=extmap:').forEach(function (line) {
          description.headerExtensions.push(SDPUtils.parseExtmap(line));
        });
        // FIXME: parse rtcp.
        return description;
      };

      // Generates parts of the SDP media section describing the capabilities /
      // parameters.
      SDPUtils.writeRtpDescription = function (kind, caps) {
        var sdp = '';

        // Build the mline.
        sdp += 'm=' + kind + ' ';
        sdp += caps.codecs.length > 0 ? '9' : '0'; // reject if no codecs.
        sdp += ' UDP/TLS/RTP/SAVPF ';
        sdp += caps.codecs.map(function (codec) {
          if (codec.preferredPayloadType !== undefined) {
            return codec.preferredPayloadType;
          }
          return codec.payloadType;
        }).join(' ') + '\r\n';
        sdp += 'c=IN IP4 0.0.0.0\r\n';
        sdp += 'a=rtcp:9 IN IP4 0.0.0.0\r\n';

        // Add a=rtpmap lines for each codec. Also fmtp and rtcp-fb.
        caps.codecs.forEach(function (codec) {
          sdp += SDPUtils.writeRtpMap(codec);
          sdp += SDPUtils.writeFmtp(codec);
          sdp += SDPUtils.writeRtcpFb(codec);
        });
        var maxptime = 0;
        caps.codecs.forEach(function (codec) {
          if (codec.maxptime > maxptime) {
            maxptime = codec.maxptime;
          }
        });
        if (maxptime > 0) {
          sdp += 'a=maxptime:' + maxptime + '\r\n';
        }
        if (caps.headerExtensions) {
          caps.headerExtensions.forEach(function (extension) {
            sdp += SDPUtils.writeExtmap(extension);
          });
        }
        // FIXME: write fecMechanisms.
        return sdp;
      };

      // Parses the SDP media section and returns an array of
      // RTCRtpEncodingParameters.
      SDPUtils.parseRtpEncodingParameters = function (mediaSection) {
        var encodingParameters = [];
        var description = SDPUtils.parseRtpParameters(mediaSection);
        var hasRed = description.fecMechanisms.indexOf('RED') !== -1;
        var hasUlpfec = description.fecMechanisms.indexOf('ULPFEC') !== -1;

        // filter a=ssrc:... cname:, ignore PlanB-msid
        var ssrcs = SDPUtils.matchPrefix(mediaSection, 'a=ssrc:').map(function (line) {
          return SDPUtils.parseSsrcMedia(line);
        }).filter(function (parts) {
          return parts.attribute === 'cname';
        });
        var primarySsrc = ssrcs.length > 0 && ssrcs[0].ssrc;
        var secondarySsrc = void 0;
        var flows = SDPUtils.matchPrefix(mediaSection, 'a=ssrc-group:FID').map(function (line) {
          var parts = line.substr(17).split(' ');
          return parts.map(function (part) {
            return parseInt(part, 10);
          });
        });
        if (flows.length > 0 && flows[0].length > 1 && flows[0][0] === primarySsrc) {
          secondarySsrc = flows[0][1];
        }
        description.codecs.forEach(function (codec) {
          if (codec.name.toUpperCase() === 'RTX' && codec.parameters.apt) {
            var encParam = {
              ssrc: primarySsrc,
              codecPayloadType: parseInt(codec.parameters.apt, 10)
            };
            if (primarySsrc && secondarySsrc) {
              encParam.rtx = {
                ssrc: secondarySsrc
              };
            }
            encodingParameters.push(encParam);
            if (hasRed) {
              encParam = JSON.parse(JSON.stringify(encParam));
              encParam.fec = {
                ssrc: primarySsrc,
                mechanism: hasUlpfec ? 'red+ulpfec' : 'red'
              };
              encodingParameters.push(encParam);
            }
          }
        });
        if (encodingParameters.length === 0 && primarySsrc) {
          encodingParameters.push({
            ssrc: primarySsrc
          });
        }

        // we support both b=AS and b=TIAS but interpret AS as TIAS.
        var bandwidth = SDPUtils.matchPrefix(mediaSection, 'b=');
        if (bandwidth.length) {
          if (bandwidth[0].indexOf('b=TIAS:') === 0) {
            bandwidth = parseInt(bandwidth[0].substr(7), 10);
          } else if (bandwidth[0].indexOf('b=AS:') === 0) {
            // use formula from JSEP to convert b=AS to TIAS value.
            bandwidth = parseInt(bandwidth[0].substr(5), 10) * 1000 * 0.95 - 50 * 40 * 8;
          } else {
            bandwidth = undefined;
          }
          encodingParameters.forEach(function (params) {
            params.maxBitrate = bandwidth;
          });
        }
        return encodingParameters;
      };

      // parses http://draft.ortc.org/#rtcrtcpparameters*
      SDPUtils.parseRtcpParameters = function (mediaSection) {
        var rtcpParameters = {};

        // Gets the first SSRC. Note that with RTX there might be multiple
        // SSRCs.
        var remoteSsrc = SDPUtils.matchPrefix(mediaSection, 'a=ssrc:').map(function (line) {
          return SDPUtils.parseSsrcMedia(line);
        }).filter(function (obj) {
          return obj.attribute === 'cname';
        })[0];
        if (remoteSsrc) {
          rtcpParameters.cname = remoteSsrc.value;
          rtcpParameters.ssrc = remoteSsrc.ssrc;
        }

        // Edge uses the compound attribute instead of reducedSize
        // compound is !reducedSize
        var rsize = SDPUtils.matchPrefix(mediaSection, 'a=rtcp-rsize');
        rtcpParameters.reducedSize = rsize.length > 0;
        rtcpParameters.compound = rsize.length === 0;

        // parses the rtcp-mux attrіbute.
        // Note that Edge does not support unmuxed RTCP.
        var mux = SDPUtils.matchPrefix(mediaSection, 'a=rtcp-mux');
        rtcpParameters.mux = mux.length > 0;
        return rtcpParameters;
      };
      SDPUtils.writeRtcpParameters = function (rtcpParameters) {
        var sdp = '';
        if (rtcpParameters.reducedSize) {
          sdp += 'a=rtcp-rsize\r\n';
        }
        if (rtcpParameters.mux) {
          sdp += 'a=rtcp-mux\r\n';
        }
        if (rtcpParameters.ssrc !== undefined && rtcpParameters.cname) {
          sdp += 'a=ssrc:' + rtcpParameters.ssrc + ' cname:' + rtcpParameters.cname + '\r\n';
        }
        return sdp;
      };

      // parses either a=msid: or a=ssrc:... msid lines and returns
      // the id of the MediaStream and MediaStreamTrack.
      SDPUtils.parseMsid = function (mediaSection) {
        var parts = void 0;
        var spec = SDPUtils.matchPrefix(mediaSection, 'a=msid:');
        if (spec.length === 1) {
          parts = spec[0].substr(7).split(' ');
          return {
            stream: parts[0],
            track: parts[1]
          };
        }
        var planB = SDPUtils.matchPrefix(mediaSection, 'a=ssrc:').map(function (line) {
          return SDPUtils.parseSsrcMedia(line);
        }).filter(function (msidParts) {
          return msidParts.attribute === 'msid';
        });
        if (planB.length > 0) {
          parts = planB[0].value.split(' ');
          return {
            stream: parts[0],
            track: parts[1]
          };
        }
      };

      // SCTP
      // parses draft-ietf-mmusic-sctp-sdp-26 first and falls back
      // to draft-ietf-mmusic-sctp-sdp-05
      SDPUtils.parseSctpDescription = function (mediaSection) {
        var mline = SDPUtils.parseMLine(mediaSection);
        var maxSizeLine = SDPUtils.matchPrefix(mediaSection, 'a=max-message-size:');
        var maxMessageSize = void 0;
        if (maxSizeLine.length > 0) {
          maxMessageSize = parseInt(maxSizeLine[0].substr(19), 10);
        }
        if (isNaN(maxMessageSize)) {
          maxMessageSize = 65536;
        }
        var sctpPort = SDPUtils.matchPrefix(mediaSection, 'a=sctp-port:');
        if (sctpPort.length > 0) {
          return {
            port: parseInt(sctpPort[0].substr(12), 10),
            protocol: mline.fmt,
            maxMessageSize: maxMessageSize
          };
        }
        var sctpMapLines = SDPUtils.matchPrefix(mediaSection, 'a=sctpmap:');
        if (sctpMapLines.length > 0) {
          var parts = sctpMapLines[0].substr(10).split(' ');
          return {
            port: parseInt(parts[0], 10),
            protocol: parts[1],
            maxMessageSize: maxMessageSize
          };
        }
      };

      // SCTP
      // outputs the draft-ietf-mmusic-sctp-sdp-26 version that all browsers
      // support by now receiving in this format, unless we originally parsed
      // as the draft-ietf-mmusic-sctp-sdp-05 format (indicated by the m-line
      // protocol of DTLS/SCTP -- without UDP/ or TCP/)
      SDPUtils.writeSctpDescription = function (media, sctp) {
        var output = [];
        if (media.protocol !== 'DTLS/SCTP') {
          output = ['m=' + media.kind + ' 9 ' + media.protocol + ' ' + sctp.protocol + '\r\n', 'c=IN IP4 0.0.0.0\r\n', 'a=sctp-port:' + sctp.port + '\r\n'];
        } else {
          output = ['m=' + media.kind + ' 9 ' + media.protocol + ' ' + sctp.port + '\r\n', 'c=IN IP4 0.0.0.0\r\n', 'a=sctpmap:' + sctp.port + ' ' + sctp.protocol + ' 65535\r\n'];
        }
        if (sctp.maxMessageSize !== undefined) {
          output.push('a=max-message-size:' + sctp.maxMessageSize + '\r\n');
        }
        return output.join('');
      };

      // Generate a session ID for SDP.
      // https://tools.ietf.org/html/draft-ietf-rtcweb-jsep-20#section-5.2.1
      // recommends using a cryptographically random +ve 64-bit value
      // but right now this should be acceptable and within the right range
      SDPUtils.generateSessionId = function () {
        return Math.random().toString().substr(2, 21);
      };

      // Write boiler plate for start of SDP
      // sessId argument is optional - if not supplied it will
      // be generated randomly
      // sessVersion is optional and defaults to 2
      // sessUser is optional and defaults to 'thisisadapterortc'
      SDPUtils.writeSessionBoilerplate = function (sessId, sessVer, sessUser) {
        var sessionId = void 0;
        var version = sessVer !== undefined ? sessVer : 2;
        if (sessId) {
          sessionId = sessId;
        } else {
          sessionId = SDPUtils.generateSessionId();
        }
        var user = sessUser || 'thisisadapterortc';
        // FIXME: sess-id should be an NTP timestamp.
        return 'v=0\r\n' + 'o=' + user + ' ' + sessionId + ' ' + version + ' IN IP4 127.0.0.1\r\n' + 's=-\r\n' + 't=0 0\r\n';
      };

      // Gets the direction from the mediaSection or the sessionpart.
      SDPUtils.getDirection = function (mediaSection, sessionpart) {
        // Look for sendrecv, sendonly, recvonly, inactive, default to sendrecv.
        var lines = SDPUtils.splitLines(mediaSection);
        for (var i = 0; i < lines.length; i++) {
          switch (lines[i]) {
            case 'a=sendrecv':
            case 'a=sendonly':
            case 'a=recvonly':
            case 'a=inactive':
              return lines[i].substr(2);
            default:
            // FIXME: What should happen here?
          }
        }

        if (sessionpart) {
          return SDPUtils.getDirection(sessionpart);
        }
        return 'sendrecv';
      };
      SDPUtils.getKind = function (mediaSection) {
        var lines = SDPUtils.splitLines(mediaSection);
        var mline = lines[0].split(' ');
        return mline[0].substr(2);
      };
      SDPUtils.isRejected = function (mediaSection) {
        return mediaSection.split(' ', 2)[1] === '0';
      };
      SDPUtils.parseMLine = function (mediaSection) {
        var lines = SDPUtils.splitLines(mediaSection);
        var parts = lines[0].substr(2).split(' ');
        return {
          kind: parts[0],
          port: parseInt(parts[1], 10),
          protocol: parts[2],
          fmt: parts.slice(3).join(' ')
        };
      };
      SDPUtils.parseOLine = function (mediaSection) {
        var line = SDPUtils.matchPrefix(mediaSection, 'o=')[0];
        var parts = line.substr(2).split(' ');
        return {
          username: parts[0],
          sessionId: parts[1],
          sessionVersion: parseInt(parts[2], 10),
          netType: parts[3],
          addressType: parts[4],
          address: parts[5]
        };
      };

      // a very naive interpretation of a valid SDP.
      SDPUtils.isValidSDP = function (blob) {
        if (typeof blob !== 'string' || blob.length === 0) {
          return false;
        }
        var lines = SDPUtils.splitLines(blob);
        for (var i = 0; i < lines.length; i++) {
          if (lines[i].length < 2 || lines[i].charAt(1) !== '=') {
            return false;
          }
          // TODO: check the modifier a bit more.
        }

        return true;
      };

      // Expose public methods.
      if ((typeof module === 'undefined' ? 'undefined' : _typeof(module)) === 'object') {
        module.exports = SDPUtils;
      }
    }, {}]
  }, {}, [1])(1);
});

/***/ }),

/***/ "./resources/js/index.js":
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./adapter */ "./resources/js/adapter.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_adapter__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./resources/js/utils.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_utils__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _smart_links__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./smart-links */ "./resources/js/smart-links.js");
/* harmony import */ var _smart_links__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_smart_links__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _video_sessions_utils__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./video-sessions-utils */ "./resources/js/video-sessions-utils.js");
/* harmony import */ var _video_sessions_utils__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_video_sessions_utils__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _video_sessions_manager__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./video-sessions-manager */ "./resources/js/video-sessions-manager.js");
/* harmony import */ var _video_sessions_manager__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_video_sessions_manager__WEBPACK_IMPORTED_MODULE_4__);






/***/ }),

/***/ "./resources/js/smart-links.js":
/*!*************************************!*\
  !*** ./resources/js/smart-links.js ***!
  \*************************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function linkClickHandler(_x) {
  return _linkClickHandler.apply(this, arguments);
}
function _linkClickHandler() {
  _linkClickHandler = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(e) {
    var active, res, html;
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          e.preventDefault();
          if (this._toggleActive) {
            active = this.parentNode.querySelector('.active');
            if (active !== null) active.classList.remove('active');
            this.classList.add('active');
          }
          window.history.pushState(null, '', this.getAttribute('href'));
          _context.next = 5;
          return fetch(this.getAttribute('href'), {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
        case 5:
          res = _context.sent;
          if (!res.ok) {
            _context.next = 11;
            break;
          }
          _context.next = 9;
          return res.text();
        case 9:
          html = _context.sent;
          setInnerHtml(this._target, html);
        case 11:
        case "end":
          return _context.stop();
      }
    }, _callee, this);
  }));
  return _linkClickHandler.apply(this, arguments);
}
window.makeSmartLinks = function (selector, target, toggleActive) {
  toggleActive = toggleActive === true;
  if (target === undefined) target = '#content';
  var links = document.querySelectorAll(selector);
  for (var i = 0; i < links.length; i++) {
    links[i]._target = target;
    links[i]._toggleActive = toggleActive;
    links[i].addEventListener('click', linkClickHandler);
  }
};

/***/ }),

/***/ "./resources/js/utils.js":
/*!*******************************!*\
  !*** ./resources/js/utils.js ***!
  \*******************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function easeInOutQuad(x) {
  return x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2;
}
window.animate = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(callback, duration) {
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          return _context.abrupt("return", new Promise(function (resolve) {
            if (!duration) duration = 250;
            var startTime = Date.now();
            var f = function f() {
              var k = (Date.now() - startTime) / duration;
              if (k < 1) {
                callback(k);
                requestAnimationFrame(f);
              } else {
                callback(1);
                requestAnimationFrame(resolve);
              }
            };
            requestAnimationFrame(f);
          }));
        case 1:
        case "end":
          return _context.stop();
      }
    }, _callee);
  }));
  return function (_x, _x2) {
    return _ref.apply(this, arguments);
  };
}();
window.makeElement = function (tag, className, appendTo) {
  var node = document.createElement(tag);
  node.className = className;
  if (appendTo !== undefined) appendTo.appendChild(node);
  return node;
};
window.fadeIn = /*#__PURE__*/function () {
  var _ref2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(el, duration) {
    return _regeneratorRuntime().wrap(function _callee2$(_context2) {
      while (1) switch (_context2.prev = _context2.next) {
        case 0:
          return _context2.abrupt("return", new Promise(function (resolve) {
            if (el.style.display === '' && el.style.opacity === '') return resolve();
            if (!duration) duration = 250;
            var startTime = Date.now();
            el.style.display = null;
            var f = function f() {
              var k = (Date.now() - startTime) / duration;
              if (k < 1) {
                el.style.opacity = easeInOutQuad(k);
                requestAnimationFrame(f);
              } else {
                el.style.opacity = null;
                resolve();
              }
            };
            requestAnimationFrame(f);
          }));
        case 1:
        case "end":
          return _context2.stop();
      }
    }, _callee2);
  }));
  return function (_x3, _x4) {
    return _ref2.apply(this, arguments);
  };
}();
window.fadeOut = /*#__PURE__*/function () {
  var _ref3 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3(el, duration, hide) {
    return _regeneratorRuntime().wrap(function _callee3$(_context3) {
      while (1) switch (_context3.prev = _context3.next) {
        case 0:
          return _context3.abrupt("return", new Promise(function (resolve) {
            if (el.style.display === 'none') return resolve();
            if (el.style.opacity === '0' && hide) {
              el.style.display = 'none';
              return resolve();
            }
            if (!duration) duration = 250;
            var startTime = Date.now();
            var f = function f() {
              var k = (Date.now() - startTime) / duration;
              if (k < 1) {
                el.style.opacity = 1 - easeInOutQuad(k);
                requestAnimationFrame(f);
              } else {
                el.style.opacity = 0;
                if (hide !== false) el.style.display = 'none';
                resolve();
              }
            };
            requestAnimationFrame(f);
          }));
        case 1:
        case "end":
          return _context3.stop();
      }
    }, _callee3);
  }));
  return function (_x5, _x6, _x7) {
    return _ref3.apply(this, arguments);
  };
}();
window.getScrollbarWidth = function () {
  // Creating invisible container
  var outer = document.createElement('div');
  outer.style.visibility = 'hidden';
  outer.style.overflow = 'scroll'; // forcing scrollbar to appear
  outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
  document.body.appendChild(outer);

  // Creating inner element and placing it in the container
  var inner = document.createElement('div');
  outer.appendChild(inner);

  // Calculating difference between container's full width and the child width
  var scrollbarWidth = outer.offsetWidth - inner.offsetWidth;

  // Removing temporary elements from the DOM
  outer.parentNode.removeChild(outer);
  return scrollbarWidth;
};
window.disableBodyScrollbar = function () {
  var scrollWidth = getScrollbarWidth();
  document.body.style.overflow = 'hidden';
  if (document.body.scrollHeight > document.body.clientHeight) {
    document.body.style.paddingRight = scrollWidth + 'px';
    var header = document.getElementById('header');
    if (header !== null) header.style.paddingRight = scrollWidth + 'px';
  }
};
window.enableBodyScrollbar = function () {
  document.body.style.overflow = null;
  document.body.style.paddingRight = null;
  var header = document.getElementById('header');
  if (header !== null) header.style.paddingRight = null;
};
window.prepareForm = function (form) {
  var placeholders = form.getElementsByClassName('input-placeholder');
  for (var i = 0; i < placeholders.length; i++) {
    placeholders[i].classList.remove('shown');
    var input = placeholders[i].querySelector('input');
    if (input !== null) input.style.display = null;
  }
};
window.showFormErrors = function (form, data) {
  if (data.errors !== null && Object.keys(data.errors).length > 0) {
    for (var p in data.errors) {
      if (data.errors[p].length > 0) {
        var error = form.querySelector('.error[data-for="' + p + '"]');
        if (error !== null) {
          error.textContent = data.errors[p][0];
          error.style.visibility = 'visible';
        }
      }
    }
  }
};
window.clearFormErrors = function (form) {
  var errors = form.getElementsByClassName('error');
  for (var i = 0; i < errors.length; i++) {
    errors[i].textContent = '';
    errors[i].style.visibility = null;
  }
};
var Countdown = /*#__PURE__*/function () {
  function Countdown() {
    var _this = this;
    _classCallCheck(this, Countdown);
    this.targetTime = Date.now();
    this.__updateHandler = null;
    this.__task = setInterval(function () {
      if (_this.__updateHandler !== null) {
        _this.__updateHandler(_this.toString());
      }
    }, 1000);
  }
  _createClass(Countdown, [{
    key: "onUpdate",
    value: function onUpdate(handler) {
      this.__updateHandler = handler;
    }
  }, {
    key: "setTargetTime",
    value: function setTargetTime(timestamp) {
      this.targetTime = timestamp;
    }
  }, {
    key: "toString",
    value: function toString() {
      var d = (this.targetTime - Date.now()) / 1000;
      if (d < 0) return "00:00";
      var days = Math.floor(d / 86400);
      var hours = Math.floor((d - 86400 * days) / 3600);
      var minutes = Math.floor((d - 86400 * days - 3600 * hours) / 60);
      var seconds = Math.floor(d - 86400 * days - 3600 * hours - 60 * minutes);
      var res = days > 0 ? days + (days > 1 ? 'days, ' : 'day, ') : '';
      return res + hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    }
  }]);
  return Countdown;
}();
window.Countdown = Countdown;
window.closeModal = function (node) {
  while (node !== null && !node.classList.contains('modal')) {
    node = node.parentNode;
  }
  if (node !== null) {
    node.classList.remove('shown');
  }
  setTimeout(function () {
    enableBodyScrollbar();
    clearFormErrors(node);
  }, 250);
};
window.showSpinner = /*#__PURE__*/function () {
  var _ref4 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4(target, duration) {
    var wrap;
    return _regeneratorRuntime().wrap(function _callee4$(_context4) {
      while (1) switch (_context4.prev = _context4.next) {
        case 0:
          if (duration === undefined) duration = 250;
          wrap = document.createElement('div');
          wrap.classList.add('spinner-wrap');
          wrap.innerHTML = '<div class="spinner">' + '<div class="spinner-circle">' + '<div></div><div></div><div></div><div></div><div></div><div></div><div></div>' + '<div></div><div></div><div></div><div></div><div></div><div></div><div></div>' + '<div></div><div></div>' + '</div>' + '</div>';
          wrap.style.opacity = '0';
          target.appendChild(wrap);
          _context4.next = 8;
          return animate(function (k) {
            return wrap.style.opacity = k.toString();
          }, duration);
        case 8:
        case "end":
          return _context4.stop();
      }
    }, _callee4);
  }));
  return function (_x8, _x9) {
    return _ref4.apply(this, arguments);
  };
}();
window.hideSpinner = /*#__PURE__*/function () {
  var _ref5 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5(target, message) {
    var spinner, msg, circle;
    return _regeneratorRuntime().wrap(function _callee5$(_context5) {
      while (1) switch (_context5.prev = _context5.next) {
        case 0:
          spinner = target.querySelector('.spinner-wrap');
          if (!(message !== undefined)) {
            _context5.next = 14;
            break;
          }
          msg = document.createElement('div');
          msg.classList.add('spinner-message');
          msg.textContent = message;
          msg.style.opacity = '0';
          spinner.appendChild(msg);
          circle = spinner.querySelector('.spinner-circle');
          _context5.next = 10;
          return animate(function (k) {
            return circle.style.opacity = (1 - k).toString();
          }, 150);
        case 10:
          _context5.next = 12;
          return animate(function (k) {
            return msg.style.opacity = k.toString();
          }, 150);
        case 12:
          _context5.next = 14;
          return delay(250);
        case 14:
          _context5.next = 16;
          return animate(function (k) {
            return spinner.style.opacity = (1 - k).toString();
          }, 250);
        case 16:
          spinner.parentNode.removeChild(spinner);
        case 17:
        case "end":
          return _context5.stop();
      }
    }, _callee5);
  }));
  return function (_x10, _x11) {
    return _ref5.apply(this, arguments);
  };
}();
window.delay = function (duration) {
  return new Promise(function (resolve) {
    return setTimeout(resolve, duration);
  });
};

// Sets inner HTML for the element and executes all scripts inside.
window.setInnerHtml = function (elm, html) {
  if (typeof elm === 'string') elm = document.querySelector(elm);
  elm.innerHTML = html;

  // Copy title.
  var title = elm.getElementsByTagName('title');
  if (title.length) {
    document.head.getElementsByTagName('title')[0].textContent = title[0].textContent;
    elm.removeChild(title[0]);
  }
  var metas = elm.getElementsByTagName('meta');
  for (var i = 0; i < metas.length; i++) {
    var m = document.head.querySelector('meta[name="' + metas[i].getAttribute('name') + '"]');
    if (m !== null) document.head.replaceChild(metas[i], m);
    metas[i].parentNode.removeChild(metas[i]);
  }
  Array.from(elm.querySelectorAll("script")).forEach(function (oldScript) {
    var newScript = document.createElement("script");
    Array.from(oldScript.attributes).forEach(function (attr) {
      return newScript.setAttribute(attr.name, attr.value);
    });
    newScript.appendChild(document.createTextNode(oldScript.innerHTML));
    oldScript.parentNode.replaceChild(newScript, oldScript);
  });
};
function getQueryParam(variable, defaultValue) {
  var query = window.location.search.substring(1);
  var vars = query.split('&');
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split('=');
    if (decodeURIComponent(pair[0]) === variable) {
      return decodeURIComponent(pair[1]);
    }
  }
  return defaultValue;
}
window.initTableSorting = function (table, searchForm) {
  if (typeof table === 'string') table = document.querySelector(table);
  if (typeof searchForm === 'string') searchForm = document.querySelector(searchForm);
  var sortInput = searchForm.querySelector('input[name="sort"]');
  var orderInput = searchForm.querySelector('input[name="order"]');
  if (sortInput === null) {
    sortInput = document.createElement('input');
    sortInput.setAttribute('type', 'hidden');
    sortInput.setAttribute('name', 'sort');
    sortInput.value = getQueryParam('sort', '');
    searchForm.appendChild(sortInput);
  }
  if (orderInput === null) {
    orderInput = document.createElement('input');
    orderInput.setAttribute('type', 'hidden');
    orderInput.setAttribute('name', 'order');
    orderInput.value = getQueryParam('order', 'asc');
    searchForm.appendChild(orderInput);
  }
  function tableHeaderHandler() {
    sortInput.value = this.dataset.sort;
    orderInput.value = orderInput.value === 'asc' ? 'desc' : 'asc';
    searchForm.submit();
  }
  var ths = table.getElementsByTagName('th');
  for (var i = 0; i < ths.length; i++) {
    ths[i].addEventListener('click', tableHeaderHandler);
    var name = ths[i].dataset.sort;
    if (name !== sortInput.value) continue;
    var arrow = document.createElement('div');
    arrow.className = 'table_sorting-arrow';
    arrow.classList.add(orderInput.value);
    ths[i].appendChild(arrow);
  }
};
function tabClickHandler(e) {
  var active = this.parentNode.querySelector('.active');
  if (active !== null) {
    var activeContent = document.querySelector(active.dataset["for"]);
    if (activeContent !== null) {
      activeContent.style.display = 'none';
    }
    active.classList.remove('active');
  }
  this.classList.add('active');
  var content = document.querySelector(this.dataset["for"]);
  if (content !== null) {
    content.style.display = null;
  }
}
document.addEventListener('DOMContentLoaded', function () {
  var tabs = document.getElementsByClassName('tabs');
  for (var i = 0; i < tabs.length; i++) {
    var items = tabs[i].getElementsByClassName('tab');
    for (var j = 0; j < items.length; j++) {
      items[j].addEventListener('click', tabClickHandler);
    }
  }
});
window.makeTextareaAsMessageInput = function (textarea) {
  if (typeof textarea === 'string') textarea = document.querySelector(textarea);
  if (textarea === null) {
    console.error('Textarea is null');
    return;
  }
  textarea.addEventListener('keydown', function (e) {
    if (!e.shiftKey && !e.ctrlKey && e.key === 'Enter') {
      if (textarea.value.trim() !== '') {
        textarea.dispatchEvent(new CustomEvent('send', {
          detail: textarea.value
        }));
        textarea.value = '';
      }
      e.preventDefault();
    }
  });
  textarea.addEventListener('input', function (e) {
    textarea.style.height = 0;
    textarea.style.height = textarea.scrollHeight + 'px';
    textarea.style.overflowY = textarea.scrollHeight > 180 ? 'auto' : 'hidden';
  });
};

/***/ }),

/***/ "./resources/js/video-sessions-manager.js":
/*!************************************************!*\
  !*** ./resources/js/video-sessions-manager.js ***!
  \************************************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); Object.defineProperty(subClass, "prototype", { writable: false }); if (superClass) _setPrototypeOf(subClass, superClass); }
function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }
function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }
function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e5) { throw _e5; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e6) { didErr = true; err = _e6; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
(function () {
  "use strict";

  var A;
  !function (A) {
    A.AUTH_REQUIRED = "auth-required", A.CONNECTED = "connected", A.AUTHORIZED = "authorized", A.DISCONNECTED = "disconnected", A.UPDATE_USER = "update-user", A.ACTIVE_VIDEO_SESSION = "active-video-session", A.VIDEO_SESSION_DETAILS = "video-session-details", A.VIDEO_STREAM_READY = "video-stream-ready", A.LOCAL_VIDEO_STREAM_READY = "local-video-stream-ready", A.REMOTE_VIDEO_STREAM_READY = "remote-video-stream-ready", A.VIDEO_SESSIONS_LIST = "video-sessions-list", A.COUNTRIES_LIST = "countries-list", A.HIGHLIGHT_MEMBERS = "highlight-members", A.ERROR_MESSAGE = "error-message", A.START_TALK = "start-talk", A.END_TALK = "end-talk", A.TALK_RESULT = "talk-result", A.NOTIFICATIONS_LIST = "notifications-list", A.NEW_NOTIFICATION = "new-notifications", A.SEE_NOTIFICATION = "see-notification", A.CONVERSATIONS_LIST = "conversations-list", A.INCOMING_MESSAGE = "incoming-message", A.MESSAGES_LIST = "messages-list", A.SEE_MESSAGE = "see-message", A.CONVERSATION_UPDATE = "conversation-update", A.NEW_COMPLAINT_MESSAGE = "new-complaint-message";
  }(A || (A = {}));
  var e = A,
    t = "VS: ",
    i = {
      info: function info() {
        var _console;
        for (var _len = arguments.length, A = new Array(_len), _key = 0; _key < _len; _key++) {
          A[_key] = arguments[_key];
        }
        (_console = console).log.apply(_console, [t].concat(A));
      },
      warn: function warn() {
        var _console2;
        for (var _len2 = arguments.length, A = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
          A[_key2] = arguments[_key2];
        }
        (_console2 = console).warn.apply(_console2, [t].concat(A));
      },
      error: function error() {
        var _console3;
        for (var _len3 = arguments.length, A = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
          A[_key3] = arguments[_key3];
        }
        (_console3 = console).error.apply(_console3, [t].concat(A));
      }
    };
  var n = /*#__PURE__*/function () {
    function n() {
      _classCallCheck(this, n);
      this._ws = null, this._messagesHandler = null, this._connectHandler = null, this._disconnectHandler = null, this._queue = [];
    }
    _createClass(n, [{
      key: "setHost",
      value: function setHost(A) {
        this._host = A;
      }
    }, {
      key: "connect",
      value: function connect() {
        var _this = this;
        i.info("Connecting to the signaling server"), this._ws = new WebSocket(this._host), this._ws.onopen = function () {
          i.info("Successfully connected to the signaling server"), null !== _this._connectHandler && _this._connectHandler();
        }, this._ws.onmessage = function (A) {
          if (null !== _this._messagesHandler) try {
            _this._messagesHandler(JSON.parse(A.data));
          } catch (A) {
            i.error("Unable to parse incoming message: ", A);
          }
        }, this._ws.onclose = function (A) {
          null !== _this._disconnectHandler && _this._disconnectHandler(), setTimeout(function () {
            i.info("Connection to signaling server has been closed. Trying to reconnect..."), _this.connect();
          }, 1e3);
        };
      }
    }, {
      key: "processQueue",
      value: function processQueue() {
        for (var _A = 0; _A < this._queue.length; _A++) this._ws.readyState == WebSocket.OPEN && this.sendInternal(this._queue[_A]);
        this._queue = [];
      }
    }, {
      key: "onConnect",
      value: function onConnect(A) {
        this._connectHandler = A;
      }
    }, {
      key: "onDisconnect",
      value: function onDisconnect(A) {
        this._disconnectHandler = A;
      }
    }, {
      key: "onMessage",
      value: function onMessage(A) {
        this._messagesHandler = A;
      }
    }, {
      key: "sendBinary",
      value: function sendBinary(A) {
        i.info(">>> [Binary data]", A.size), this._ws.send(A);
      }
    }, {
      key: "send",
      value: function send(A) {
        null !== this._ws && this._ws.readyState === WebSocket.OPEN ? this.sendInternal(A) : this._queue.push(A);
      }
    }, {
      key: "sendSilent",
      value: function sendSilent(A) {
        null !== this._ws && this._ws.send(JSON.stringify(A));
      }
    }, {
      key: "sendInternal",
      value: function sendInternal(A) {
        i.info(">>>", A.action), this._ws.send(JSON.stringify(A));
      }
    }]);
    return n;
  }();
  var o;
  !function (A) {
    A.CONFIGURATION = "config", A.AUTH = "auth", A.UPDATE_USER = "update-user", A.RTC_OFFER = "rtc-offer", A.RTC_ANSWER = "rtc-answer", A.RTC_ICE = "rtc-ice", A.CREATE_VIDEO_SESSION = "create-video-session", A.DELETE_VIDEO_SESSION = "delete-video-session", A.ACTIVE_VIDEO_SESSION = "active-video-session", A.VIDEO_SESSIONS_LIST = "video-sessions-list", A.COUNTRIES_LIST = "countries-list", A.VIDEO_SESSION_DETAILS = "video-session-details", A.VIDEO_SESSION_UPDATED = "video-session-updated", A.JOIN_VIDEO_SESSION = "join-video-session", A.LEAVE_VIDEO_SESSION = "leave-video-session", A.HIGHLIGHT_MEMBERS = "highlight-members", A.ERROR_MESSAGE = "error-message", A.START_TALK = "start-talk", A.END_TALK = "end-talk", A.RATE_TALK = "rate-talk", A.TALK_RESULT = "talk-result", A.LEAVE_TALK = "leave-talk", A.RESTART_SERVER = "restart-server", A.LOGS = "logs", A.NOTIFICATIONS_LIST = "notifications-list", A.NEW_NOTIFICATION = "new-notification", A.SEE_NOTIFICATION = "see-notification", A.SEND_NOTIFICATION = "send-notification", A.SEND_NOTIFICATION_TO_ALL = "send-notification-to-all", A.CONVERSATIONS_LIST = "conversations-list", A.SEND_MESSAGE = "send-message", A.INCOMING_MESSAGE = "incoming-message", A.MESSAGES_LIST = "messages-list", A.SEE_MESSAGE = "see-message", A.CONVERSATION_UPDATE = "conversation-update", A.SEND_COMPLAINT_MESSAGE = "send-complaint-message", A.NEW_COMPLAINT_MESSAGE = "new-complaint-message";
  }(o || (o = {}));
  var s = o;
  var a = /*#__PURE__*/function () {
    function a() {
      _classCallCheck(this, a);
      this._handlers = new Map();
    }
    _createClass(a, [{
      key: "addEventHandler",
      value: function addEventHandler(A, e) {
        this._handlers.has(A) || this._handlers.set(A, new Set()), this._handlers.get(A).add(e);
      }
    }, {
      key: "dispatchEvent",
      value: function dispatchEvent(A, e) {
        if (this._handlers.has(A)) {
          var _iterator = _createForOfIteratorHelper(this._handlers.get(A)),
            _step;
          try {
            for (_iterator.s(); !(_step = _iterator.n()).done;) {
              var _t = _step.value;
              _t(e);
            }
          } catch (err) {
            _iterator.e(err);
          } finally {
            _iterator.f();
          }
        }
      }
    }]);
    return a;
  }();
  var r = function r(A, e, t, i) {
    return new (t || (t = Promise))(function (n, o) {
      function s(A) {
        try {
          r(i.next(A));
        } catch (A) {
          o(A);
        }
      }
      function a(A) {
        try {
          r(i["throw"](A));
        } catch (A) {
          o(A);
        }
      }
      function r(A) {
        var e;
        A.done ? n(A.value) : (e = A.value, e instanceof t ? e : new t(function (A) {
          A(e);
        })).then(s, a);
      }
      r((i = i.apply(A, e || [])).next());
    });
  };
  var d = /*#__PURE__*/function () {
    function d() {
      var _this2 = this;
      _classCallCheck(this, d);
      this._recordedStream = null, this._canvas = document.createElement("canvas"), this._localVideo = document.createElement("video"), this._remoteVideo = document.createElement("video"), this._onRecordedChunkReady = null, this._recorder = null, this._audioContext = null, this._isRecording = !1, this._localVideo.volume = 0, this._remoteVideo.volume = 0, this._remoteVideo.addEventListener("loadedmetadata", function () {
        _this2._remoteVideo.play()["catch"](function (A) {
          return i.error("Unable to play remote video:", A);
        });
      });
    }
    _createClass(d, [{
      key: "startRecording",
      value: function startRecording(A, e, t) {
        return r(this, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
          var _this3 = this;
          var i;
          return _regeneratorRuntime().wrap(function _callee$(_context) {
            while (1) switch (_context.prev = _context.next) {
              case 0:
                i = t;
                this._isRecording = !0;
                _context.next = 4;
                return this.composeRecordedVideo(A, e);
              case 4:
                this._recordedStream = _context.sent;
                this._recorder = new MediaRecorder(this._recordedStream, {
                  videoBitsPerSecond: 102400,
                  mimeType: "video/webm; codecs=vp8,opus"
                });
                this._recorder.ondataavailable = function (A) {
                  null !== _this3._onRecordedChunkReady && _this3._onRecordedChunkReady(A.data, i);
                };
                this._recorder.start(1e3);
              case 8:
              case "end":
                return _context.stop();
            }
          }, _callee, this);
        }));
      }
    }, {
      key: "stopRecording",
      value: function stopRecording() {
        this._isRecording = !1, this._localVideo.srcObject = null, this._remoteVideo.srcObject = null, null !== this._recorder && (this._recorder.stop(), this._recorder = null), null !== this._audioContext && (this._audioContext.close()["catch"](function (A) {
          return i.error(A);
        }), this._audioContext = null), null !== this._recordedStream && (this._recordedStream.getTracks().forEach(function (A) {
          return A.stop();
        }), this._recordedStream = null);
      }
    }, {
      key: "composeRecordedVideo",
      value: function composeRecordedVideo(A, e) {
        var _this4 = this;
        return new Promise(function (t) {
          return r(_this4, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
            var _this5 = this;
            var i, n;
            return _regeneratorRuntime().wrap(function _callee2$(_context2) {
              while (1) switch (_context2.prev = _context2.next) {
                case 0:
                  this._localVideo.srcObject = null, this._remoteVideo.srcObject = null, this._remoteVideo.addEventListener("loadedmetadata", function () {
                    var n = _this5._canvas,
                      o = n.getContext("2d");
                    n.width = Math.floor(_this5._remoteVideo.videoWidth / 3), n.height = Math.floor(_this5._remoteVideo.videoHeight / 3);
                    var s = function s() {
                      if (!_this5._localVideo.paused && !_this5._localVideo.ended) {
                        var _A2 = .35,
                          _e = _this5._localVideo,
                          _t2 = _e.videoWidth - n.width > _e.videoHeight - n.height ? n.width / _e.videoWidth : n.height / _e.videoHeight,
                          _i = Math.round(_e.videoWidth * _A2 * _t2),
                          _a = Math.round(_e.videoHeight * _A2 * _t2);
                        if (null !== _this5._remoteVideo) {
                          var _A3 = _this5._remoteVideo,
                            _e2 = _A3.videoWidth - n.width > _A3.videoHeight - n.height ? n.width / _A3.videoWidth : n.height / _A3.videoHeight;
                          o.drawImage(_this5._remoteVideo, _A3.videoWidth - n.width > _A3.videoHeight - n.height ? 0 : n.width / 2 - _A3.videoWidth * _e2 / 2, _A3.videoWidth - n.width > _A3.videoHeight - n.height ? n.height / 2 - _A3.videoHeight * _e2 / 2 : 0, _A3.videoWidth * _e2, _A3.videoHeight * _e2);
                        } else o.fillStyle = "#000", o.fillRect(0, 0, n.width, n.height);
                        o.drawImage(_this5._localVideo, n.width - _i, n.height - _a, _i, _a), _this5._isRecording && setTimeout(s, 1e3 / 30);
                      }
                    };
                    if (s(), i = n.captureStream(30), void 0 !== window.AudioContext) {
                      _this5._audioContext = new AudioContext();
                      var _t3 = _this5._audioContext.createMediaStreamSource(A),
                        _n = _this5._audioContext.createMediaStreamSource(e),
                        _o = _this5._audioContext.createMediaStreamDestination();
                      _t3.connect(_o), _n.connect(_o), _o.stream.getAudioTracks().length > 0 && i.addTrack(_o.stream.getAudioTracks()[0]);
                    } else A.getAudioTracks().forEach(function (A) {
                      return i.addTrack(A);
                    });
                    t(i);
                  });
                  n = new MediaStream();
                  A.getVideoTracks().forEach(function (A) {
                    return n.addTrack(A);
                  });
                  this._localVideo.srcObject = n;
                  _context2.next = 6;
                  return this._localVideo.play();
                case 6:
                  n = new MediaStream();
                  e.getVideoTracks().forEach(function (A) {
                    return n.addTrack(A);
                  });
                  this._remoteVideo.srcObject = n;
                  _context2.next = 11;
                  return this._remoteVideo.play();
                case 11:
                case "end":
                  return _context2.stop();
              }
            }, _callee2, this);
          }));
        });
      }
    }, {
      key: "onRecordedChunkReady",
      value: function onRecordedChunkReady(A) {
        this._onRecordedChunkReady = A;
      }
    }]);
    return d;
  }();
  function c(A, e) {
    return new Promise(function (t) {
      var i = Date.now();
      if (!0 === A()) return t();
      var n = setInterval(function () {
        (1 == A() || void 0 !== e && Date.now() - i > e) && (clearInterval(n), t());
      }, 50);
    });
  }
  var h = function h(A, e, t, i) {
    return new (t || (t = Promise))(function (n, o) {
      function s(A) {
        try {
          r(i.next(A));
        } catch (A) {
          o(A);
        }
      }
      function a(A) {
        try {
          r(i["throw"](A));
        } catch (A) {
          o(A);
        }
      }
      function r(A) {
        var e;
        A.done ? n(A.value) : (e = A.value, e instanceof t ? e : new t(function (A) {
          A(e);
        })).then(s, a);
      }
      r((i = i.apply(A, e || [])).next());
    });
  };
  var l = /*#__PURE__*/function () {
    function l(A) {
      _classCallCheck(this, l);
      this._connection = null, this._localStream = null, this._remoteStream = null, this._initiatesConnection = !1, this._iceCandidates = [], this._videoSender = null, this._audioSender = null, this._isMuted = !1, this._gettingLocalStream = !1, this._onLocalStreamReady = null, this._onAllStreamsReady = null, this._signalingServer = A, this.createLocalStream()["catch"](function (A) {
        return i.error(A);
      });
    }
    _createClass(l, [{
      key: "mute",
      value: function mute() {
        this._audioSender.track.enabled = !1;
      }
    }, {
      key: "unmute",
      value: function unmute() {
        this._audioSender.track.enabled = !0;
      }
    }, {
      key: "isInitiator",
      value: function isInitiator() {
        return this._initiatesConnection;
      }
    }, {
      key: "configure",
      value: function configure(A) {
        var _this6 = this;
        null === this._connection ? (this._connection = new RTCPeerConnection(A), this._connection.addEventListener("iceconnectionstatechange", function () {
          "failed" === _this6._connection.iceConnectionState && _this6._connection.restartIce();
        }), this._connection.onnegotiationneeded = function () {
          return h(_this6, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
            var _A4;
            return _regeneratorRuntime().wrap(function _callee3$(_context3) {
              while (1) switch (_context3.prev = _context3.next) {
                case 0:
                  if (!(i.info("Negotiation needed"), this._initiatesConnection)) {
                    _context3.next = 15;
                    break;
                  }
                  _context3.prev = 1;
                  _context3.next = 4;
                  return this._connection.createOffer();
                case 4:
                  _A4 = _context3.sent;
                  _context3.next = 7;
                  return this._connection.setLocalDescription(_A4);
                case 7:
                  this._signalingServer.send({
                    action: s.RTC_OFFER,
                    sdp: _A4.sdp
                  });
                  _context3.next = 13;
                  break;
                case 10:
                  _context3.prev = 10;
                  _context3.t0 = _context3["catch"](1);
                  i.error("Unable to set local offer:", _context3.t0);
                case 13:
                  _context3.next = 16;
                  break;
                case 15:
                  this._connection.restartIce();
                case 16:
                case "end":
                  return _context3.stop();
              }
            }, _callee3, this, [[1, 10]]);
          }));
        }, this._connection.ontrack = function (A) {
          A.track.onunmute = function () {
            "video" === A.track.kind && (_this6._remoteStream = A.streams[0], null !== _this6._onAllStreamsReady && _this6._onAllStreamsReady(_this6._localStream, _this6._remoteStream));
          };
        }, this._connection.onicecandidate = function (A) {
          A.candidate && _this6._signalingServer.send({
            action: s.RTC_ICE,
            ice: A.candidate
          });
        }) : i.warn("Trying to configure peer connection when it's already configured.");
      }
    }, {
      key: "initiateConnection",
      value: function initiateConnection() {
        return h(this, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
          return _regeneratorRuntime().wrap(function _callee4$(_context4) {
            while (1) switch (_context4.prev = _context4.next) {
              case 0:
                this._initiatesConnection = !0;
                if (!("connected" !== this._connection.connectionState)) {
                  _context4.next = 6;
                  break;
                }
                _context4.next = 4;
                return this.createLocalStream();
              case 4:
                _context4.next = 7;
                break;
              case 6:
                i.info("Connection already established");
              case 7:
              case "end":
                return _context4.stop();
            }
          }, _callee4, this);
        }));
      }
    }, {
      key: "reconnect",
      value: function reconnect() {
        null !== this._connection && (i.info("Reconnecting..."), this._connection.restartIce());
      }
    }, {
      key: "setRtcAnswer",
      value: function setRtcAnswer(A) {
        return h(this, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
          return _regeneratorRuntime().wrap(function _callee5$(_context5) {
            while (1) switch (_context5.prev = _context5.next) {
              case 0:
                _context5.prev = 0;
                _context5.next = 3;
                return this._connection.setRemoteDescription({
                  type: "answer",
                  sdp: A
                });
              case 3:
                _context5.next = 5;
                return this.setCachedIceCandidates();
              case 5:
                _context5.next = 10;
                break;
              case 7:
                _context5.prev = 7;
                _context5.t0 = _context5["catch"](0);
                i.error("Unable to set remote answer:", _context5.t0);
              case 10:
              case "end":
                return _context5.stop();
            }
          }, _callee5, this, [[0, 7]]);
        }));
      }
    }, {
      key: "setRtcOffer",
      value: function setRtcOffer(A) {
        return h(this, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
          var _e3;
          return _regeneratorRuntime().wrap(function _callee6$(_context6) {
            while (1) switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return this.createLocalStream();
              case 2:
                _context6.prev = 2;
                _context6.next = 5;
                return this._connection.setRemoteDescription({
                  type: "offer",
                  sdp: A
                });
              case 5:
                _context6.next = 7;
                return this.setCachedIceCandidates();
              case 7:
                _context6.next = 9;
                return this._connection.createAnswer();
              case 9:
                _e3 = _context6.sent;
                _context6.next = 12;
                return this._connection.setLocalDescription(_e3);
              case 12:
                this._signalingServer.send({
                  action: s.RTC_ANSWER,
                  sdp: _e3.sdp
                });
                _context6.next = 18;
                break;
              case 15:
                _context6.prev = 15;
                _context6.t0 = _context6["catch"](2);
                i.error("Unable to set local answer:", _context6.t0);
              case 18:
              case "end":
                return _context6.stop();
            }
          }, _callee6, this, [[2, 15]]);
        }));
      }
    }, {
      key: "createLocalStream",
      value: function createLocalStream() {
        var _this7 = this;
        return new Promise(function (A) {
          return h(_this7, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee7() {
            var _this8 = this;
            return _regeneratorRuntime().wrap(function _callee7$(_context7) {
              while (1) switch (_context7.prev = _context7.next) {
                case 0:
                  if (!(null === this._localStream)) {
                    _context7.next = 16;
                    break;
                  }
                  if (!this._gettingLocalStream) {
                    _context7.next = 5;
                    break;
                  }
                  _context7.next = 4;
                  return c(function () {
                    return !1 === _this8._gettingLocalStream;
                  });
                case 4:
                  return _context7.abrupt("return", void A(this._localStream));
                case 5:
                  this._gettingLocalStream = !0;
                  i.info("Created local stream");
                  _context7.next = 9;
                  return navigator.mediaDevices.getUserMedia({
                    video: !0,
                    audio: !0
                  });
                case 9:
                  this._localStream = _context7.sent;
                  null !== this._onLocalStreamReady && this._onLocalStreamReady(this._localStream);
                  if (!(null === this._connection)) {
                    _context7.next = 13;
                    break;
                  }
                  return _context7.abrupt("return", A(this._localStream));
                case 13:
                  this._localStream.getTracks().forEach(function (A) {
                    var e = _this8._connection.addTrack(A, _this8._localStream);
                    "audio" === A.kind ? (_this8._isMuted && (e.track.enabled = !1), _this8._audioSender = e) : _this8._videoSender = e;
                  }), this._gettingLocalStream = !1;
                  _context7.next = 17;
                  break;
                case 16:
                  A(this._localStream);
                case 17:
                case "end":
                  return _context7.stop();
              }
            }, _callee7, this);
          }));
        });
      }
    }, {
      key: "setRemoteIce",
      value: function setRemoteIce(A) {
        null === this._connection.remoteDescription ? this._iceCandidates.push(A) : this._connection.addIceCandidate(A)["catch"](function (A) {
          i.error("Unable to set remote ice:", A);
        });
      }
    }, {
      key: "setCachedIceCandidates",
      value: function setCachedIceCandidates() {
        return h(this, void 0, void 0, /*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
          var A, _e4;
          return _regeneratorRuntime().wrap(function _callee8$(_context8) {
            while (1) switch (_context8.prev = _context8.next) {
              case 0:
                A = [];
                for (_e4 = 0; _e4 < this._iceCandidates.length; _e4++) A.push(this._connection.addIceCandidate(this._iceCandidates[_e4]));
                _context8.next = 4;
                return Promise.all(A)["catch"](function (A) {
                  return i.error("Unable to set remote ice:", A);
                });
              case 4:
                this._iceCandidates = [];
              case 5:
              case "end":
                return _context8.stop();
            }
          }, _callee8, this);
        }));
      }
    }, {
      key: "disconnect",
      value: function disconnect() {
        null !== this._localStream && this._localStream.getTracks().forEach(function (A) {
          return A.stop();
        }), this._localStream = null, this._remoteStream = null, this._connection.close();
      }
    }, {
      key: "onLocalStreamReady",
      value: function onLocalStreamReady(A) {
        this._onLocalStreamReady = A;
      }
    }, {
      key: "onAllStreamsReady",
      value: function onAllStreamsReady(A) {
        this._onAllStreamsReady = A;
      }
    }]);
    return l;
  }();
  var E = function E() {
      return "undefined" != typeof navigator && parseFloat(("" + (/CPU.*OS ([0-9_]{3,4})[0-9_]{0,1}|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent) || [0, ""])[1]).replace("undefined", "3_2").replace("_", ".").replace("_", "")) < 10 && !window.MSStream;
    },
    g = function g() {
      return "wakeLock" in navigator;
    },
    S = new ( /*#__PURE__*/function () {
      function _class() {
        var _this9 = this;
        _classCallCheck(this, _class);
        if (this._enabled = !1, this._wakeLock = null, this.noSleepTimer = null, this.noSleepVideo = null, g()) {
          var _A5 = function _A5() {
            null !== _this9._wakeLock && "visible" === document.visibilityState && _this9.enable()["catch"](function (A) {
              return i.error(A);
            });
          };
          document.addEventListener("visibilitychange", _A5), document.addEventListener("fullscreenchange", _A5);
        } else this.noSleepVideo = document.createElement("video"), this.noSleepVideo.setAttribute("title", "No Sleep"), this.noSleepVideo.setAttribute("playsinline", ""), this.noSleepVideo.addEventListener("loadedmetadata", function () {
          _this9.noSleepVideo.duration <= 1 ? _this9.noSleepVideo.setAttribute("loop", "") : _this9.noSleepVideo.addEventListener("timeupdate", function () {
            _this9.noSleepVideo.currentTime > .5 && (_this9.noSleepVideo.currentTime = Math.random());
          });
        }), this.addSourceToVideo(this.noSleepVideo, "webm", "data:video/webm;base64,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"), this.addSourceToVideo(this.noSleepVideo, "mp4", "data:video/mp4;base64,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");
      }
      _createClass(_class, [{
        key: "addSourceToVideo",
        value: function addSourceToVideo(A, e, t) {
          var i = document.createElement("source");
          i.src = t, i.type = "video/".concat(e), A.appendChild(i);
        }
      }, {
        key: "enable",
        value: function enable() {
          var _this10 = this;
          return g() ? navigator.wakeLock.request("screen").then(function (A) {
            _this10._wakeLock = A, _this10._enabled = !0, i.info("Wake Lock active."), _this10._wakeLock.addEventListener("release", function () {
              i.info("Wake Lock released.");
            });
          })["catch"](function (A) {
            _this10._enabled = !1, i.error("".concat(A.name, ", ").concat(A.message));
          }) : E() ? (this.disable(), i.warn("\n                Wake enabled for older iOS devices. This can interrupt\n                active or long-running network requests from completing successfully.\n                See https://github.com/richtr/NoSleep.js/issues/15 for more details.\n            "), this.noSleepTimer = window.setInterval(function () {
            document.hidden || (window.location.href = window.location.href.split("#")[0], window.setTimeout(window.stop, 0));
          }, 15e3), this._enabled = !0, Promise.resolve()) : this.noSleepVideo.play().then(function (A) {
            return _this10._enabled = !0, A;
          })["catch"](function (A) {
            _this10._enabled = !1, i.error(A);
          });
        }
      }, {
        key: "disable",
        value: function disable() {
          g() ? (this._wakeLock && this._wakeLock.release()["catch"](function (A) {
            return i.error(A);
          }), this._wakeLock = null) : E() ? null !== this.noSleepTimer && (i.warn("Wake now disabled for older iOS devices."), window.clearInterval(this.noSleepTimer), this.noSleepTimer = null) : this.noSleepVideo.pause(), this._enabled = !1;
        }
      }]);
      return _class;
    }())();
  var I;
  !function (A) {
    A[A.TEXT = 0] = "TEXT", A[A.IMAGE = 1] = "IMAGE", A[A.SMILE = 2] = "SMILE";
  }(I || (I = {}));
  var C = I;
  window.VideoSessionsManager = /*#__PURE__*/function (_a2) {
    _inherits(_class2, _a2);
    var _super = _createSuper(_class2);
    function _class2() {
      var _this11;
      _classCallCheck(this, _class2);
      _this11 = _super.call(this), _this11._signalingServer = null, _this11._videoProcessor = null, _this11._peerConfig = null, _this11._peerConnection = null, _this11._logIndex = 0, _this11._userId = null, _this11._authorized = !1, _this11._isAdmin = !1, _this11._isTalking = !1, _this11._currentVideoId = null, _this11._lastVideoId = null, _this11._logsHijacking = !1, S.enable()["catch"](function (A) {
        return i.error(A);
      }), _this11.prepareVideoProcessor(), _this11.prepareSignalingServer();
      return _this11;
    }
    _createClass(_class2, [{
      key: "setUserId",
      value: function setUserId(A) {
        null == this._userId && (this._userId = A);
      }
    }, {
      key: "prepareVideoProcessor",
      value: function prepareVideoProcessor() {
        var _this12 = this;
        this._videoProcessor = new d(), this._videoProcessor.onRecordedChunkReady(function (A, e) {
          var t = new TextEncoder().encode(e),
            i = (n = t.length, Uint8Array.of((4278190080 & n) >> 24, (16711680 & n) >> 16, (65280 & n) >> 8, (255 & n) >> 0));
          var n;
          var o = new Blob([i, t, A]);
          _this12._signalingServer.sendBinary(o);
        });
      }
    }, {
      key: "prepareSignalingServer",
      value: function prepareSignalingServer() {
        var _this13 = this;
        this._signalingServer = new n();
        var A = function A(_A6) {
          _this13._signalingServer.send({
            action: s.AUTH,
            payload: _A6
          });
        };
        this._signalingServer.onConnect(function () {
          _this13.dispatchEvent(e.CONNECTED, A), _this13.dispatchEvent(e.AUTH_REQUIRED, A);
        }), this._signalingServer.onDisconnect(function () {
          _this13._authorized = !1, _this13.dispatchEvent(e.DISCONNECTED);
        }), this._signalingServer.onMessage(function (A) {
          _this13.handleSignalingMessage(A);
        });
      }
    }, {
      key: "handleSignalingMessage",
      value: function handleSignalingMessage(A) {
        if (i.info("<<<", A.action), A.action !== s.CONFIGURATION) {
          if (A.action !== s.COUNTRIES_LIST) {
            if (A.action !== s.VIDEO_SESSIONS_LIST) {
              if (A.action === s.AUTH || this._authorized) switch (A.action) {
                case s.AUTH:
                  "ok" === A.payload.toLowerCase() && (this._authorized = !0, this._isAdmin = A.isAdmin, this.dispatchEvent(e.AUTHORIZED, this._isAdmin));
                  break;
                case s.ACTIVE_VIDEO_SESSION:
                  this.dispatchEvent(e.ACTIVE_VIDEO_SESSION, A.videoSessionInfo);
                  break;
                case s.VIDEO_SESSION_DETAILS:
                  this.dispatchEvent(e.VIDEO_SESSION_DETAILS, {
                    info: A.videoSessionInfo,
                    contacts: A.contacts
                  });
                  break;
                case s.HIGHLIGHT_MEMBERS:
                  this.dispatchEvent(e.HIGHLIGHT_MEMBERS, {
                    videoSessionId: A.videoSessionId,
                    members: A.members
                  });
                  break;
                case s.ERROR_MESSAGE:
                  this.dispatchEvent(e.ERROR_MESSAGE, A.message);
                  break;
                case s.START_TALK:
                  var _t4 = !this._isTalking;
                  this._isTalking = !0;
                  var _n2 = this._currentVideoId !== A.videoId;
                  this._currentVideoId = A.videoId, this._lastVideoId = A.videoId, null !== this._peerConnection && _t4 ? this._userId === A.initiator && (_n2 && this._videoProcessor.stopRecording(), this._peerConnection.reconnect()) : (this.createPeerConnection(), this._userId === A.initiator && this._peerConnection.initiateConnection()["catch"](function (A) {
                    return i.error(A);
                  })), this.dispatchEvent(e.START_TALK, this._userId === A.initiator);
                  break;
                case s.END_TALK:
                  this._isTalking = !1, this._currentVideoId = null, null !== this._peerConnection && this._peerConnection.disconnect(), this._peerConnection = null, this._videoProcessor.stopRecording(), this.dispatchEvent(e.END_TALK);
                  break;
                case s.TALK_RESULT:
                  this.dispatchEvent(e.TALK_RESULT, A.talkResult);
                  break;
                case s.RTC_OFFER:
                  null === this._peerConnection && this.createPeerConnection(), this._peerConnection.setRtcOffer(A.sdp);
                  break;
                case s.RTC_ANSWER:
                  null === this._peerConnection && this.createPeerConnection(), this._peerConnection.setRtcAnswer(A.sdp);
                  break;
                case s.RTC_ICE:
                  null === this._peerConnection && this.createPeerConnection(), this._peerConnection.setRemoteIce(A.ice);
                  break;
                case s.NOTIFICATIONS_LIST:
                  this.dispatchEvent(e.NOTIFICATIONS_LIST, A.notifications);
                  break;
                case s.NEW_NOTIFICATION:
                  this.dispatchEvent(e.NEW_NOTIFICATION, A.notification);
                  break;
                case s.CONVERSATIONS_LIST:
                  this.dispatchEvent(e.CONVERSATIONS_LIST, A.conversations);
                  break;
                case s.INCOMING_MESSAGE:
                  this.dispatchEvent(e.INCOMING_MESSAGE, {
                    message: A.message,
                    conversationId: A.conversationId
                  });
                  break;
                case s.MESSAGES_LIST:
                  this.dispatchEvent(e.MESSAGES_LIST, {
                    conversationId: A.conversationId,
                    messages: A.messages
                  });
                  break;
                case s.CONVERSATION_UPDATE:
                  this.dispatchEvent(e.CONVERSATION_UPDATE, A.conversation);
                  break;
                case s.NEW_COMPLAINT_MESSAGE:
                  this.dispatchEvent(e.NEW_COMPLAINT_MESSAGE, {
                    complaintId: A.complaintId,
                    message: A.message
                  });
                  break;
                default:
                  i.warn("Unacceptable action: " + A.action);
              }
            } else this.dispatchEvent(e.VIDEO_SESSIONS_LIST, A.videoSessions);
          } else this.dispatchEvent(e.COUNTRIES_LIST, A.countries);
        } else A.logs && this.hijackLogs();
      }
    }, {
      key: "leaveTalk",
      value: function leaveTalk(A) {
        this._signalingServer.send({
          action: s.LEAVE_TALK,
          comment: A
        });
      }
    }, {
      key: "createPeerConnection",
      value: function createPeerConnection() {
        var _this14 = this;
        this._peerConnection = new l(this._signalingServer), null === this._peerConfig && i.error("RTCConfiguration is not set"), this._peerConnection.configure(this._peerConfig), this._peerConnection.onLocalStreamReady(function (A) {
          _this14.dispatchEvent(e.LOCAL_VIDEO_STREAM_READY, A);
        }), this._peerConnection.onAllStreamsReady(function (A, t) {
          _this14._peerConnection.isInitiator() && (_this14._videoProcessor.stopRecording(), _this14._videoProcessor.startRecording(A, t, _this14._currentVideoId)["catch"](function (A) {
            return i.error(A);
          })), _this14.dispatchEvent(e.REMOTE_VIDEO_STREAM_READY, t);
        });
      }
    }, {
      key: "connectToSignalingServer",
      value: function connectToSignalingServer(A) {
        this._signalingServer.setHost(A), this._signalingServer.connect();
      }
    }, {
      key: "configureRTCPeer",
      value: function configureRTCPeer(A) {
        this._peerConfig = A, null !== this._peerConnection && this._peerConnection.configure(A);
      }
    }, {
      key: "initiateConnection",
      value: function initiateConnection() {
        this._peerConnection.initiateConnection();
      }
    }, {
      key: "muteMicrophone",
      value: function muteMicrophone() {
        this._peerConnection.mute();
      }
    }, {
      key: "unmuteMicrophone",
      value: function unmuteMicrophone() {
        this._peerConnection.unmute();
      }
    }, {
      key: "isAuthorized",
      value: function isAuthorized() {
        return this._authorized;
      }
    }, {
      key: "createVideoSession",
      value: function createVideoSession(A) {
        this._signalingServer.send({
          action: s.CREATE_VIDEO_SESSION,
          videoSessionInfo: A
        });
      }
    }, {
      key: "deleteVideoSession",
      value: function deleteVideoSession(A) {
        this._signalingServer.send({
          action: s.DELETE_VIDEO_SESSION,
          videoSessionId: A
        });
      }
    }, {
      key: "requestCountriesListUpdate",
      value: function requestCountriesListUpdate() {
        this._signalingServer.send({
          action: s.COUNTRIES_LIST
        });
      }
    }, {
      key: "requestUserUpdate",
      value: function requestUserUpdate() {
        this._signalingServer.send({
          action: s.UPDATE_USER
        });
      }
    }, {
      key: "requestVideoSessionsListUpdate",
      value: function requestVideoSessionsListUpdate(A) {
        this._signalingServer.send({
          action: s.VIDEO_SESSIONS_LIST,
          country: A
        });
      }
    }, {
      key: "requestVideoSessionDetails",
      value: function requestVideoSessionDetails(A) {
        this._signalingServer.send({
          action: s.VIDEO_SESSION_DETAILS,
          videoSessionId: A
        });
      }
    }, {
      key: "joinVideoSession",
      value: function joinVideoSession(A) {
        this._signalingServer.send({
          action: s.JOIN_VIDEO_SESSION,
          videoSessionId: A
        });
      }
    }, {
      key: "leaveVideoSession",
      value: function leaveVideoSession(A) {
        this._signalingServer.send({
          action: s.LEAVE_VIDEO_SESSION,
          videoSessionId: A
        });
      }
    }, {
      key: "requestTalkResult",
      value: function requestTalkResult() {
        this._signalingServer.send({
          action: s.TALK_RESULT
        });
      }
    }, {
      key: "requestConversationsList",
      value: function requestConversationsList() {
        this._signalingServer.send({
          action: s.CONVERSATIONS_LIST
        });
      }
    }, {
      key: "requestMessagesList",
      value: function requestMessagesList(A, e) {
        this._signalingServer.send({
          action: s.MESSAGES_LIST,
          conversationId: A,
          fromId: e
        });
      }
    }, {
      key: "sendMessage",
      value: function sendMessage(A, e) {
        this._signalingServer.send({
          action: s.SEND_MESSAGE,
          conversationId: e,
          type: C.TEXT,
          text: A
        });
      }
    }, {
      key: "seeMessage",
      value: function seeMessage(A, e) {
        this._signalingServer.send({
          action: s.SEE_MESSAGE,
          conversationId: A,
          messageId: e
        });
      }
    }, {
      key: "sendNotification",
      value: function sendNotification(A, e) {
        this._signalingServer.send({
          action: s.SEND_NOTIFICATION,
          userId: A,
          message: e
        });
      }
    }, {
      key: "sendNotificationToAll",
      value: function sendNotificationToAll(A, e) {
        this._signalingServer.send({
          action: s.SEND_NOTIFICATION_TO_ALL,
          users: A,
          message: e
        });
      }
    }, {
      key: "onConnect",
      value: function onConnect(A) {
        this.addEventHandler(e.CONNECTED, A);
      }
    }, {
      key: "onAuthorized",
      value: function onAuthorized(A) {
        this.addEventHandler(e.AUTHORIZED, A);
      }
    }, {
      key: "onAuthRequired",
      value: function onAuthRequired(A) {
        this.addEventHandler(e.AUTH_REQUIRED, A);
      }
    }, {
      key: "onActiveVideoSession",
      value: function onActiveVideoSession(A) {
        this.addEventHandler(e.ACTIVE_VIDEO_SESSION, A);
      }
    }, {
      key: "onVideoStreamReady",
      value: function onVideoStreamReady(A) {
        this.addEventHandler(e.VIDEO_STREAM_READY, A);
      }
    }, {
      key: "onLocalVideoStreamReady",
      value: function onLocalVideoStreamReady(A) {
        this.addEventHandler(e.LOCAL_VIDEO_STREAM_READY, A);
      }
    }, {
      key: "onRemoteVideoStreamReady",
      value: function onRemoteVideoStreamReady(A) {
        this.addEventHandler(e.REMOTE_VIDEO_STREAM_READY, A);
      }
    }, {
      key: "onCountriesListUpdate",
      value: function onCountriesListUpdate(A) {
        this.addEventHandler(e.COUNTRIES_LIST, A);
      }
    }, {
      key: "onVideoSessionsListUpdate",
      value: function onVideoSessionsListUpdate(A) {
        this.addEventHandler(e.VIDEO_SESSIONS_LIST, A);
      }
    }, {
      key: "onVideoSessionDetails",
      value: function onVideoSessionDetails(A) {
        this.addEventHandler(e.VIDEO_SESSION_DETAILS, A);
      }
    }, {
      key: "onHighlightMembers",
      value: function onHighlightMembers(A) {
        this.addEventHandler(e.HIGHLIGHT_MEMBERS, A);
      }
    }, {
      key: "onErrorMessage",
      value: function onErrorMessage(A) {
        this.addEventHandler(e.ERROR_MESSAGE, A);
      }
    }, {
      key: "onStartTalk",
      value: function onStartTalk(A) {
        this.addEventHandler(e.START_TALK, A);
      }
    }, {
      key: "onEndTalk",
      value: function onEndTalk(A) {
        this.addEventHandler(e.END_TALK, A);
      }
    }, {
      key: "onTalkResult",
      value: function onTalkResult(A) {
        this.addEventHandler(e.TALK_RESULT, A);
      }
    }, {
      key: "onNotificationsUpdate",
      value: function onNotificationsUpdate(A) {
        this.addEventHandler(e.NOTIFICATIONS_LIST, A);
      }
    }, {
      key: "onNewNotification",
      value: function onNewNotification(A) {
        this.addEventHandler(e.NEW_NOTIFICATION, A);
      }
    }, {
      key: "onConversationsListUpdate",
      value: function onConversationsListUpdate(A) {
        this.addEventHandler(e.CONVERSATIONS_LIST, A);
      }
    }, {
      key: "onConversationUpdate",
      value: function onConversationUpdate(A) {
        this.addEventHandler(e.CONVERSATION_UPDATE, A);
      }
    }, {
      key: "onIncomingMessage",
      value: function onIncomingMessage(A) {
        this.addEventHandler(e.INCOMING_MESSAGE, A);
      }
    }, {
      key: "onMessagesUpdate",
      value: function onMessagesUpdate(A) {
        this.addEventHandler(e.MESSAGES_LIST, A);
      }
    }, {
      key: "onComplaintMessage",
      value: function onComplaintMessage(A) {
        this.addEventHandler(e.NEW_COMPLAINT_MESSAGE, A);
      }
    }, {
      key: "seeNotification",
      value: function seeNotification(A) {
        this._signalingServer.send({
          action: s.SEE_NOTIFICATION,
          id: A
        });
      }
    }, {
      key: "rateLastTalk",
      value: function rateLastTalk(A) {
        this._signalingServer.send({
          action: s.RATE_TALK,
          rate: A
        });
      }
    }, {
      key: "sendComplaintMessage",
      value: function sendComplaintMessage(A, e) {
        this._signalingServer.send({
          action: s.SEND_COMPLAINT_MESSAGE,
          complaintId: A,
          message: e
        });
      }
    }, {
      key: "restartServer",
      value: function restartServer() {
        this._signalingServer.send({
          action: s.RESTART_SERVER
        });
      }
    }, {
      key: "hijackLogs",
      value: function hijackLogs() {
        return A = this, e = void 0, i = /*#__PURE__*/_regeneratorRuntime().mark(function i() {
          var _this15 = this;
          var A, e, t;
          return _regeneratorRuntime().wrap(function i$(_context9) {
            while (1) switch (_context9.prev = _context9.next) {
              case 0:
                if (!this._logsHijacking) {
                  _context9.next = 2;
                  break;
                }
                return _context9.abrupt("return");
              case 2:
                this._logsHijacking = !0;
                _context9.next = 5;
                return c(function () {
                  return _this15._authorized;
                });
              case 5:
                A = console.log, e = console.warn, t = console.error;
                this.saveLogs(navigator.userAgent, "", 1), console.log = function () {
                  for (var _len4 = arguments.length, e = new Array(_len4), _key4 = 0; _key4 < _len4; _key4++) {
                    e[_key4] = arguments[_key4];
                  }
                  _this15.saveLogs("Log:   " + e.join(" "), "", 1), A.apply(console, e);
                }, console.warn = function () {
                  for (var _len5 = arguments.length, A = new Array(_len5), _key5 = 0; _key5 < _len5; _key5++) {
                    A[_key5] = arguments[_key5];
                  }
                  _this15.saveLogs("Warn:  " + A.join(" "), "", 1), e.apply(console, A);
                }, console.error = function () {
                  for (var _len6 = arguments.length, A = new Array(_len6), _key6 = 0; _key6 < _len6; _key6++) {
                    A[_key6] = arguments[_key6];
                  }
                  _this15.saveLogs("Error: " + A.join(" "), "", 1), t.apply(console, A);
                }, window.onerror = function (A, e, t) {
                  _this15.saveLogs(A, e, t);
                };
              case 7:
              case "end":
                return _context9.stop();
            }
          }, i, this);
        }), new ((t = void 0) || (t = Promise))(function (n, o) {
          function s(A) {
            try {
              r(i.next(A));
            } catch (A) {
              o(A);
            }
          }
          function a(A) {
            try {
              r(i["throw"](A));
            } catch (A) {
              o(A);
            }
          }
          function r(A) {
            var e;
            A.done ? n(A.value) : (e = A.value, e instanceof t ? e : new t(function (A) {
              A(e);
            })).then(s, a);
          }
          r((i = i.apply(A, e || [])).next());
        });
        var A, e, t, i;
      }
    }, {
      key: "saveLogs",
      value: function saveLogs(A, e, t) {
        this._signalingServer.sendSilent({
          action: s.LOGS,
          message: A,
          file: e,
          line: t,
          index: this._logIndex++
        });
      }
    }]);
    return _class2;
  }(a);
})();

/***/ }),

/***/ "./resources/js/video-sessions-utils.js":
/*!**********************************************!*\
  !*** ./resources/js/video-sessions-utils.js ***!
  \**********************************************/
/***/ (() => {

window.formatTime = function (time) {
  var startedAt = new Date(time);
  var day = startedAt.getDate().toString().padStart(2, '0');
  var month = startedAt.getMonth().toString().padStart(2, '0');
  var year = startedAt.getFullYear();
  var hours = startedAt.getHours().toString().padStart(2, '0');
  var minutes = startedAt.getMinutes().toString().padStart(2, '0');
  return '' + day + '.' + month + '.' + year + ' at ' + hours + ':' + minutes;
};
window.createSessionInfo = function (vs, showDeleteButton, deleteSessionInfoHandler) {
  var startedAt = new Date(vs.startedAt);
  var day = startedAt.getDate().toString().padStart(2, '0');
  var month = startedAt.getMonth().toString().padStart(2, '0');
  var year = startedAt.getFullYear();
  var hours = startedAt.getHours().toString().padStart(2, '0');
  var minutes = startedAt.getMinutes().toString().padStart(2, '0');
  var sexuality = vs.sexuality === 0 ? 'straight' : vs.sexuality === 1 ? 'lesbian' : 'gay';
  if (vs.sexuality === 3) sexuality = 'straight';
  var info = document.createElement('div');
  info.className = 'vs-list-item__info';
  info.dataset.id = vs.id;
  info.innerHTML = "\n        <div class=\"vs-list-item__icon-wrap\">\n            <svg viewBox=\"0 0 13 14\" width=\"36\" height=\"36\">\n                <use href=\"/images/icons.svg#sexuality-".concat(sexuality, "\"></use>\n            </svg>\n        </div>\n        <div class=\"vs-list-item__age\">\n            <div class=\"vs-list-item__age-label\">Age limit:</div>\n            <div class=\"vs-list-item__age-text\">").concat(vs.minAge === 0 ? 'Any age' : vs.minAge + ' - ' + vs.maxAge, "</div>\n        </div>\n        <div class=\"vs-list-item__purpose\">\n            <div class=\"vs-list-item__purpose-label\">Purpose:</div>\n            <div class=\"vs-list-item__purpose-text\">").concat(localization.enums.purpose[vs.purpose], "</div>\n        </div>\n        <div class=\"vs-list-item__location\">\n            <div class=\"vs-list-item__location-label\">Location:</div>\n            <div class=\"vs-list-item__location-text\">").concat(localization.enums.country[vs.country], "</div>\n        </div>\n        <div class=\"vs-list-item__date-wrap\">\n            <div class=\"vs-list-item__date\">").concat(day, ".").concat(month, ".").concat(year, "</div>\n            <div class=\"vs-list-item__time\">").concat(hours, ":").concat(minutes, "</div>\n        </div>");
  if (showDeleteButton) {
    var deleteButton = document.createElement('div');
    deleteButton.className = 'vs-list-item__delete-button';
    deleteButton.innerHTML = "&times;";
    deleteButton.addEventListener('click', deleteSessionInfoHandler);
    info.appendChild(deleteButton);
  }
  return info;
};

/***/ }),

/***/ "./resources/css/index.css":
/*!*********************************!*\
  !*** ./resources/css/index.css ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/script": 0,
/******/ 			"css/index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/index"], () => (__webpack_require__("./resources/js/index.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/index"], () => (__webpack_require__("./resources/css/index.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;