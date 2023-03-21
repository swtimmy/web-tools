<script>
var useEdge = false
var useDebug = false
function fromTop() {
  nativeToast({
    message: 'No more posts',
    position: 'top',
    edge: useEdge,
    debug: useDebug
  })
}
function fromBottom() {
  nativeToast({
    message: 'No more posts',
    edge: useEdge,
    debug: useDebug
  })
}
function fromCenter() {
  nativeToast({
    message: 'No more posts',
    position: 'center',
    edge: useEdge,
    debug: useDebug
  })
}
function squared() {
  nativeToast({
    message: 'No more posts',
    square: true,
    edge: useEdge,
    debug: useDebug
  })
}
function error() {
  nativeToast({
    message: 'Something bad happened!',
    type: 'error',
    edge: useEdge,
    debug: useDebug
  })
}
function info() {
  nativeToast({
    message: 'Some information!',
    type: 'info',
    edge: useEdge,
    debug: useDebug
  })
}
function warning() {
  nativeToast.warning({
    message: 'Something warning!',
    edge: useEdge,
    debug: useDebug
  })
}
function success() {
  nativeToast({
    message: 'Success message!',
    type: 'success',
    edge: useEdge,
    debug: useDebug
  })
}
function edge() {
  nativeToast({
    message: 'Bottom edge!',
    edge: useEdge,
    debug: useDebug
  })
}
document.getElementById('switch-edge-mode').addEventListener('change', function (e) {
  useEdge = e.target.checked
})
document.getElementById('switch-debug-mode').addEventListener('change', function (e) {
  useDebug = e.target.checked
})
</script>