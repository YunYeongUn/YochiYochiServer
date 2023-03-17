<template>
  <div id="app">
    <h2>게시판 리스트</h2>

    <div class="listWrap">
      <table class="tbList">
        <colgroup>
          <col width="6%" />
          <col width="*" />
          <col width="10%" />
          <col width="15%" />
        </colgroup>
        <tr>
          <th>no</th>
          <th>제목</th>
          <th>글쓴이</th>
          <th>날짜</th>
        </tr>

        <tr v-for="(row, idx) in postlist" :key="idx">
          <td>{{ idx }}</td>
          <td class="txt_left">
            <router-link :to="'community/'.concat(row.id)">{{
              row.post_title
            }}</router-link>
          </td>
          <td>{{ row.users.name }}</td>
          <td>{{ row.created_at.substring(0, 10) }}</td>
        </tr>
      </table>
    </div>

    <div class="btnRightWrap">
      <button type="button">등록</button>
    </div>
  </div>
</template>

<script>
import { createApp } from "vue";

export default {
  data() {
    //변수생성
    return {
      postlist: "",
      no: "",
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      await this.axios
        .get("http://localhost/api/community")
        .then((res) => {
          console.log(res.staus);
          console.log(res.data);
          this.postlist = res.data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          console.log("항상 마지막에 실행");
        });
    },
  },
};
</script>

<style scoped>
.searchWrap {
  border: 1px solid #888;
  border-radius: 5px;
  text-align: center;
  padding: 20px 0;
  margin-bottom: 40px;
}
.searchWrap input {
  width: 60%;
  height: 36px;
  border-radius: 3px;
  padding: 0 10px;
  border: 1px solid #888;
}
.searchWrap .btnSearch {
  display: inline-block;
  margin-left: 10px;
}
.tbList th {
  border-top: 1px solid #888;
}
.tbList th,
.tbList td {
  border-bottom: 1px solid #eee;
  padding: 5px 0;
}
.tbList td.txt_left {
  text-align: left;
}
.btnRightWrap {
  text-align: right;
  margin: 10px 0 0 0;
}

.pagination {
  margin: 20px 0 0 0;
  text-align: center;
}
.first,
.prev,
.next,
.last {
  border: 1px solid #666;
  margin: 0 5px;
}
.pagination span {
  display: inline-block;
  padding: 0 5px;
  color: #333;
}
.pagination a {
  text-decoration: none;
  display: inline-blcok;
  padding: 0 5px;
  color: #666;
}
</style>
