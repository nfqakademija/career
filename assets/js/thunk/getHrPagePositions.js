import Axios from "axios";
import { setPositions } from "../Actions/action";

export const getHrPagePositions = () => (dispatch, getState) => {
  Axios.get("/api/profession/list", {
    headers: { Authorization: `Bearer ${getState().token.token}` }
  })
    .then(res => {
      dispatch(setPositions(res.data.list));
    })
    .catch(err => console.log(err));
};
