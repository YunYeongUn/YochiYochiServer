<template>
  <div id="app">
    <h2>QnA 리스트</h2>

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
          <th>답변여부</th>
          <th>글쓴이</th>
          <th>날짜</th>
        </tr>
        <tr v-for="(row, idx) in qnalist" :key="idx">
          <td>{{ no - idx }}</td>
          <td class="txt_left">
            <router-link :to="'qna/'.concat(row.id)">{{
              row.qna_title
            }}</router-link>
          </td>
          <td>{{ row.answer }}</td>
          <td>{{ row.users.name }}</td>
          <td>{{ row.created_at.substring(0, 10) }}</td>
        </tr>

        <!-- <tr v-if="postlist.length == 0">
					<td colspan="4">데이터가 없습니다.</td>
				</tr> -->
      </table>
    </div>

    <div class="btnRightWrap">
      <a @click="Add" class="btn">등록</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    //변수생성
    return {
      qnalist: "",
      no: "",
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      await this.axios
        .get("http://localhost/api/qna")
        .then((res) => {
          console.log(res.staus);
          console.log(res.data);
          this.qnalist = res.data;
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
