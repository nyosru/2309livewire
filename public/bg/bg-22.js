const shader = {
	vertex: `void main() {
	gl_Position = vec4( position, 1.0 );
    }`,
	fragment: `   uniform vec2 u_resolution;
    uniform float u_time;
    uniform vec2 u_mouse;
	
    const int octaves = 8;
    const float seed = 43758.5453123;
    const float seed2 = 73156.8473192;
	
    float random(float val) {
	return fract(sin(val) * seed);
    }
	
    vec2 random2(vec2 st, float seed){
	st = vec2( dot(st,vec2(127.1,311.7)),
	dot(st,vec2(269.5,183.3)) );
	return -1.0 + 2.0*fract(sin(st)*seed);
    }
	
    float random2d(vec2 uv) {
	return fract(
	sin(
	dot( uv.xy, vec2(12.9898, 78.233) )
	) * seed);
    }
	
    // Value Noise by Inigo Quilez - iq/2013
    // https://www.shadertoy.com/view/lsf3WH
    float noise(vec2 st, float seed) {
	vec2 i = floor(st);
	vec2 f = fract(st);
	
	vec2 u = f*f*(3.0-2.0*f);
	
	return mix( mix( dot( random2(i + vec2(0.0,0.0), seed ), f - vec2(0.0,0.0) ), 
	dot( random2(i + vec2(1.0,0.0), seed ), f - vec2(1.0,0.0) ), u.x),
	mix( dot( random2(i + vec2(0.0,1.0), seed ), f - vec2(0.0,1.0) ), 
	dot( random2(i + vec2(1.0,1.0), seed ), f - vec2(1.0,1.0) ), u.x), u.y);
    }
	// Simplex 2D noise
	//
	vec3 permute(vec3 x) { return mod(((x*34.0)+1.0)*x, 289.0); }
	
	float snoise(vec2 v){
    const vec4 C = vec4(0.211324865405187, 0.366025403784439,
	-0.577350269189626, 0.024390243902439);
    vec2 i  = floor(v + dot(v, C.yy) );
    vec2 x0 = v -   i + dot(i, C.xx);
    vec2 i1;
    i1 = (x0.x > x0.y) ? vec2(1.0, 0.0) : vec2(0.0, 1.0);
    vec4 x12 = x0.xyxy + C.xxzz;
    x12.xy -= i1;
    i = mod(i, 289.0);
    vec3 p = permute( permute( i.y + vec3(0.0, i1.y, 1.0 ))
    + i.x + vec3(0.0, i1.x, 1.0 ));
    vec3 m = max(0.5 - vec3(dot(x0,x0), dot(x12.xy,x12.xy),
	dot(x12.zw,x12.zw)), 0.0);
    m = m*m ;
    m = m*m ;
    vec3 x = 2.0 * fract(p * C.www) - 1.0;
    vec3 h = abs(x) - 0.5;
    vec3 ox = floor(x + 0.5);
    vec3 a0 = x - ox;
    m *= 1.79284291400159 - 0.85373472095314 * ( a0*a0 + h*h );
    vec3 g;
    g.x  = a0.x  * x0.x  + h.x  * x0.y;
    g.yz = a0.yz * x12.xz + h.yz * x12.yw;
    return 130.0 * dot(m, g);
	}
	
    vec3 plotCircle(vec2 pos, vec2 uv, float size) {
	return vec3(smoothstep(size, size + 0.05, length(uv - pos)));
    }
	
    float fbm (in vec2 st, float seed) {
	// Initial values
	float value = 0.0;
	float amplitude = .5;
	float frequency = 0.;
	//
	// Loop of octaves
	for (int i = octaves; i > 0; i--) {
	value += amplitude * abs(noise(st, seed));
	st *= 2.;
	amplitude *= .5;
	}
	return value;
	}
    float fbm1(in vec2 _st, float seed) {
	float v = 0.0;
	float a = 0.5;
	vec2 shift = vec2(100.0);
	// Rotate to reduce axial bias
	mat2 rot = mat2(cos(0.5), sin(0.5),
	-sin(0.5), cos(0.50));
	for (int i = 0; i < octaves; ++i) {
	v += a * noise(_st, seed);
	_st = rot * _st * 2.0 + shift;
	a *= 0.4;
	}
	return v;
	}
	
	float pattern(vec2 uv, float seed, float time, inout vec2 q, inout vec2 r) {
    
    q = vec2( fbm1( uv + vec2(0.0,0.0), seed ),
	fbm1( uv + vec2(5.2,1.3), seed ) );
	
    r = vec2( fbm1( uv + 2.0*q + vec2(1.7 - time / 2.,9.2), seed ),
	fbm1( uv + 2.0*q + vec2(8.3 - time / 2.,2.8), seed ) );
	
    vec2 s = vec2( fbm1( uv + 6.0*r + vec2(21.7 - time / 2.,90.2), seed ),
	fbm1( uv + 6.0*r + vec2(80.3 - time / 2.,20.8), seed ) );
	
    vec2 t = vec2( fbm1( uv + 1.0*s + vec2(121.7 - time / 2.,190.2), seed ),
	fbm1( uv + 1.0*s + vec2(180.3 - time / 2.,120.8), seed ) );
    
    return fbm1( uv + 4.0*t, seed );
	}
	
	vec3 hsv2rgb(vec3 c) {
    vec4 K = vec4(1.0, 2.0 / 3.0, 1.0 / 3.0, 3.0);
    vec3 p = abs(fract(c.xxx + K.xyz) * 6.0 - K.www);
    return c.z * mix(K.xxx, clamp(p - K.xxx, 0.0, 1.0), c.y);
	}
	
    void main() {
	vec2 uv = (gl_FragCoord.xy - 0.5 * u_resolution.xy) / u_resolution.y;
	
	float time = u_time / 10.;
	
	mat2 rot = mat2(cos(time / 10.), sin(time / 10.),
	-sin(time / 10.), cos(time / 10.));
	
	uv = rot * uv;
	uv *= sin(u_time / 20.) + 3.;
	uv.x -= time / 5.;
	
	vec2 q = vec2(0.,0.);
	vec2 r = vec2(0.,0.);
	
	float noiseval = pattern(uv * .2, seed, time, q, r);
	// noiseval = pattern(uv / noiseval / 5000., seed, time, q, r);
	// q *= 2.;
	vec3 colour = vec3(.6 + noiseval);
	colour += q.x + q.y;
	colour.r -= dot(q, r) * 15.;
	colour = mix(colour, vec3(pattern(r, seed2, time, q, r), dot(q, r) * 15., 0.), .5);
	// colour -= q.y * 1.5;
	colour -= fract(noiseval * 2.) / 100.;
	// colour = 0.5 - colour;
	// colour += fract(q.x * 2.) / 2.;
	// colour.g += dot(q, r) * 15.;
	
	// colour = hsv2rgb(colour);
	
	// gl_FragColor = vec4(abs(colour), 1.);
	gl_FragColor = vec4(colour + abs(colour), 1.);
    }`
};
/*
	Most of the stuff in here is just bootstrapping. Essentially it's just
	setting ThreeJS up so that it renders a flat surface upon which to draw 
	the shader. The only thing to see here really is the uniforms sent to 
	the shader. Apart from that all of the magic happens in the HTML view
	under the fragment shader.
*/

let container;
let camera, scene, renderer;
let uniforms;
let resolutionControl;

function init() {
	container = document.getElementById( 'bg-22' );
	
	camera = new THREE.Camera();
	camera.position.z = 1;
	
	scene = new THREE.Scene();
	
	var geometry = new THREE.PlaneBufferGeometry( 2, 2 );
	
	uniforms = {
		u_time: { type: "f", value: 1000.0 },
		u_resolution: { type: "v2", value: new THREE.Vector2() },
		u_mouse: { type: "v2", value: new THREE.Vector2() }
	};
	
	var material = new THREE.ShaderMaterial( {
		uniforms: uniforms,
		vertexShader: shader.vertex,
		fragmentShader: shader.fragment
	} );
	
	var mesh = new THREE.Mesh( geometry, material );
	scene.add( mesh );
	
	renderer = new THREE.WebGLRenderer();
	renderer.setPixelRatio( window.devicePixelRatio );
	
	container.appendChild( renderer.domElement );
	
	onWindowResize();
	window.addEventListener( 'resize', onWindowResize, false );
	
}

function onWindowResize( event ) {
	renderer.setSize( container.offsetWidth, container.offsetHeight );
	uniforms.u_resolution.value.x = renderer.domElement.width / 4;
	uniforms.u_resolution.value.y = renderer.domElement.height / 4;
}

function animate() {
	requestAnimationFrame( animate );
	render();
}

function render() {
	uniforms.u_time.value += 0.05 * (1 + uniforms.u_mouse.value.x / 500);
	renderer.render( scene, camera );
}
init();
animate();
