
var XMC = function (object) {
    this.bodyID = object.bodyID;
    this.body = null;
    this.backgroundLayerID = object.backgroundLayerID;
    this.backgroundLayer = null;
    this.selector = object.selector;
    this.selectorValue = object.selectorValue;
    this.btnCloseId = object.btnId;
    this.btnClose = null;

    if('styleBg' in object){
        this.styleBg = object.styleBg;
    }

    if('styleBody' in object){
        this.styleBody = object.styleBody;
    }

    if('btnStyle' in object){
        this.styleBtn = object.btnStyle;
    }

    if('content' in object){
        this.content = object.content;
    } else {
        console.error('content not found');
    }

    if('classListBg' in object){
        this.classListBg = object.classListBg;
    }

    if('classListBody' in object){
        this.classListBody = object.classListBody;
    }

    if('classListBtn' in object){
        this.classListBtn = object.classListBtn;
    }



    this.delegateClick();
};
XMC.prototype.initBackground = function () {
    if(this.backgroundLayer === null){
        this.backgroundLayer = document.createElement('div');
        this.backgroundLayer.id = this.backgroundLayerID;
        document.body.appendChild(this.backgroundLayer);
        this.btnClose = document.createElement('div');
        this.btnClose.id = this.btnCloseId;
        this.btnClose.innerText = 'x';
        this.backgroundLayer.appendChild(this.btnClose);

        if(this.styleBg !== undefined){
            this.bgStyle();
        }

        if(this.classListBg !== undefined){
            this.setClasses(this.classListBg, this.backgroundLayer);
        }
        if(this.classListBtn){
            this.setClasses(this.classListBtn, this.btnClose);
        }

        if(this.styleBtn !== undefined){
            this.btnStyle();
        }

    }

    this.backgroundLayer.style.display = 'flex';
    return this;
};
XMC.prototype.bgStyle = function () {
    var mapSt = Object.keys(this.styleBg);
    var mf = this;
    mapSt.map(function (key) {
        mf.backgroundLayer.style[key] = mf.styleBg[key];
    })
};
XMC.prototype.btnStyle = function () {
    var mapSt = Object.keys(this.styleBtn);
    var mf = this;
    mapSt.map(function (key) {
        mf.btnClose.style[key] = mf.styleBtn[key];
    })
}
XMC.prototype.initTarget = function () {
    if(this.body === null){
        this.body = document.createElement('div');
        this.body.id = this.bodyID;
        this.backgroundLayer.appendChild(this.body);


        this.body.innerHTML = this.content;


        if(this.styleBody !== undefined){
            this.bodyStyle();
        }

        if(this.classListBody){
            this.setClasses(this.classListBody, this.body);
        }
        
        zsHandleContacFormEvents(jQuery);
    }
    this.body.style.display = 'flex';
    return this;
};
XMC.prototype.bodyStyle = function () {
    var mapSt = Object.keys(this.styleBody);
    var mf = this;
    mapSt.map(function (key) {
        mf.body.style[key] = mf.styleBody[key];
    })
}
XMC.prototype.show = function () {
    this.initBackground();
    this.initTarget();
};
XMC.prototype.close = function () {
    this.backgroundLayer.style.display = 'none';
    this.body.style.display = 'none';
};
XMC.prototype.delegateClick = function () {
    var mf = this;
    window.addEventListener('click', function (event) {
        if(event.target.hasAttribute(mf.selector) && event.target.getAttribute(mf.selector) === mf.selectorValue ){
            mf.show();
            mf.delegateClose();
        }
    }, mf, false);
};
XMC.prototype.delegateClose = function(){
    if(this.btnClose !== null){
        var btn = this.btnClose;
        var mf = this;
        btn.addEventListener('click', function () {
            mf.close();
        }, mf);
    }
};
XMC.prototype.setClasses = function (classes, element) {
    classes.map(function(className) {
        element.classList.add(className);
    });
}


