/* Template extension name */
var ext_name = 'demo1';

/* resource path segments */
var resource_path_public = '/Resources/Public';
var resource_path_private = '/Resources/Private';

/* fe source root */
var src = './frontend';

/* source directories */
var fe_source = src + '/assets';

/* build/destination directories */
var ext_dest_public = './web/typo3conf/ext/' + ext_name + resource_path_public;
var ext_dest_private = './web/typo3conf/ext/' + ext_name + resource_path_private;

var pathConf = {
  src: {
    js: fe_source + '/JavaScript',
    sass: fe_source + '/Sass',
    fonts: fe_source + '/Fonts',
    images: fe_source + '/Images'
  },
  dest: {
    ext: {
      public: ext_dest_public,
      js: ext_dest_public + '/JavaScript',
      css: ext_dest_public + '/Css',
      fonts: ext_dest_public + '/Fonts',
      images: ext_dest_public + '/Images'
    }
  }
};

module.exports = {
  pathConf: pathConf,
  sass: {
    src: [
      fe_source + '/Sass/app.scss'
    ],
    autoprefixer: [
      'last 4 versions',
      'safari 5',
      'ie 11',
      'opera 12.1',
      'ios 6',
      'ios 7',
      'ios 8',
      'ios 9',
      'ios 10',
      'ios 11',
      'android 4'
    ]
  },
  js: {},
  copy: {
    fonts: {
      src: pathConf.src.fonts + '/**/*'
    },
    cookieconsent: {
      src: './node_modules/cookieconsent/build/cookieconsent.min.js'
    }
  }
};
