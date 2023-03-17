<template>
  <header>
    <h1>YochiYochi</h1>
    <div>
      <ul>
        <li><a href="/">홈</a></li>
        <li><a href="/community">자유게시판</a></li>
        <li><a href="/qna">QnA</a></li>
        <li><a href="/movenet">Movenet</a></li>
      </ul>
    </div>
  </header>
</template>

<script>
export default {};
</script>

<style>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 120px;
}

ul {
  display: flex;
}

li {
  margin-left: 1rem;
  list-style: none;
}

li > a {
  color: black;
}
</style>
