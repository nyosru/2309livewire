const shader = {
	vertex: `void main() {
	gl_Position = vec4( position, 1.0 );
	}`,
	fragment: `precision mediump float;
	#extension GL_OES_standard_derivatives : enable
	uniform float time;
	uniform vec2 resolution;
	vec2 mod289(vec2 x) {
	return x - floor(x * (1.0 / 289.0)) * 289.0;
	}
	vec3 mod289(vec3 x) {
	return x - floor(x * (1.0 / 289.0)) * 289.0;
	}
	vec4 mod289(vec4 x) {
	return x - floor(x * (1.0 / 289.0)) * 289.0;
	}
	vec3 permute(vec3 x) {
	return mod289(((x*34.0)+1.0)*x);
	}
	vec4 permute(vec4 x) {
	return mod((34.0 * x + 1.0) * x, 289.0);
	}
	vec4 taylorInvSqrt(vec4 r)
	{
	return 1.79284291400159 - 0.85373472095314 * r;
	}
	float cellular2x2(vec2 P)
	{
	#define K 0.142857142857 // 1/7
	#define K2 0.0714285714285 // K/2
	vec2 Pi = mod(floor(P), 289.0);
	vec2 Pf = fract(P);
	vec4 Pfx = Pf.x + vec4(-0.5, -1.5, -0.5, -1.5); //円のサイズ
	vec4 Pfy = Pf.y + vec4(-0.5, -0.5, -1.5, -1.5); //円のサイズ
	vec4 p = permute(Pi.x + vec4(0.0, 1.0, 0.0, 1.0));
	p = permute(p + Pi.y + vec4(0.0, 0.0, 1.0, 1.0));
	vec4 ox = mod(p, 7.0)*K+K2;
	vec4 oy = mod(floor(p*K),7.0)*K+K2;
	vec4 dx = Pfx + ox*0.8;
	vec4 dy = Pfy + oy*0.8;
	vec4 d = dx * dx + dy * dy;
	d.xy = min(d.xy, d.zw);
	d.x = min(d.x, d.y);
	return d.x; // F1 duplicated, F2 not computed
	}
	float noise(vec2 p) {
	p=(p);
	return fract(sin(p.x*45.11+p.y*97.23)*878.73+733.17)*2.0-1.0;
	}
	void main(void){
	float speed=2.0;
	vec2 uv = gl_FragCoord.xy / resolution.xy;
	uv.x*=(resolution.x/resolution.y);
	vec2 GA;
	GA.x = 1.0;
	GA.y = 1.0;
	GA.x-=time*0.01+noise(uv)*0.002;
	GA.y+=time*0.01+noise(uv)*0.002;
	GA*=speed;
	float F1=0.0,F2=0.0,F3=0.0,F4=0.0,F5=0.0,N1=0.0,N2=0.0,N3=0.0,N4=0.0,N5=0.0;
	float A=0.0,A1=0.0,A2=0.0,A3=0.0,A4=0.0,A5=0.0;
	// 減衰
	A = (uv.x-(uv.y*0.1));
	A = clamp(A,0.0,1.0);
	float Snowout = 0.0;
	for(int i = 3; i < 10; i ++){
	F1 = 1.0-cellular2x2((uv+(GA*(float(i)*0.1)))*float(i));
	A1 = float(i)*0.1;
	N1 = smoothstep(0.9,1.0,F1)*0.28*A1;
	//N1 = smoothstep(1.0-(float(i)*0.002),1.0,F1)*(float(i)*float(i)*0.006)*A1;
	Snowout += N1;
	}
	Snowout += 0.7;
	gl_FragColor = vec4(Snowout*1.03, Snowout, Snowout*0.9, 1.0);
	}`
};	
var container;
var camera, scene, renderer;
var uniforms;
init();
animate();
function init() {
	container = document.getElementById('bg-4');
	camera = new THREE.Camera();
	camera.position.z = 1;
	scene = new THREE.Scene();
	var geometry = new THREE.PlaneBufferGeometry( 2, 2 );
	uniforms = {
		time: { type: "f", value: 1.0 },
		resolution: { type: "v2", value: new THREE.Vector2() }
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
	uniforms.resolution.value.x = renderer.domElement.width;
	uniforms.resolution.value.y = renderer.domElement.height;
}
function animate() {
	requestAnimationFrame( animate );
	render();
}
function render() {
	uniforms.time.value += 0.05;
	renderer.render( scene, camera );
}