import Axios from "axios";

export const submitCreatedProfiles = (obj) => (dispatch, getState) => {
  console.log(obj)
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
    })
    .catch(function (error) {
      console.log(error);
      alert("Something went wrong... Try again later");
    });
};
