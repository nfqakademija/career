import Axios from "axios";
import { setProfiles } from "../Actions/action";

export const getHrPageCriterias = () => (dispatch, getState) => {
  Axios.get("/api/criteria/list", {
    headers: { Authorization: `Bearer ${getState().token.token}` }
  })
    .then(res => {
      dispatch(setProfiles(res.data.list));
    })
    .catch(err => console.log(err));
};
