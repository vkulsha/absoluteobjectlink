"use strict";

function getPolicy(arrFunctions){ return orm("getPolicy",[currentUser.uid, arrFunctions]); }
function cO(n, lid){ return orm("cO",[n, lid]); }
function cL(oid1, oid2){ return orm("cL",[oid1, oid2]); }
