<template>
  <header>
    <h1>YochiYochi</h1>
    <div>
      <ul>
        <li><router-link to="/">홈</router-link></li>
        <li><router-link to="/community">자유게시판</router-link></li>
        <li><router-link to="/qna">QnA</router-link></li>
        <li><router-link to="/movenet">Movenet</router-link></li>
        <li>
          <router-link to="/login">login</router-link>
        </li>
        |
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
