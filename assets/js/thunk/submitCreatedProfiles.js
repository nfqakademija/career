import Axios from "axios";
import { restartCompetenceAndCriteriaLists } from "../Actions/action";

export const submitCreatedProfiles = (obj) => (dispatch, getState) => {
  Axios.post(
    "/api/profiles",
    {
      data: obj
    },
    {
      headers: { Authorization: `Bearer ${getState().token.token}` }
    }
  )
    .then(function (response) {
      alert("Created successfully");
      dispatch(restartCompetenceAndCriteriaLists())
    })
    .catch(function (error) {
      console.log(error);
      alert("Something went wrong... Try again later");
    });
};
