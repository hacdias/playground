using namespace std;

#include <stdio.h>
#include <algorithm>
#include <iostream>

struct Interval {
  int first, last, weight;
};

struct IntervalNode {
  Interval *i;
  int max;
  IntervalNode *left, *right;
};

IntervalNode * newNode(Interval i) {
  IntervalNode *temp = new IntervalNode;
  temp->i = new Interval(i);
  temp->max = i.last;
  temp->left = temp->right = NULL;
  return temp;
}

IntervalNode *insert(IntervalNode *root, Interval i) {
  if (root == NULL) return newNode(i);
  
  if (root->i->first == i.first && root->i->last == i.last) {
    root->i->weight += i.weight;
    return root;
  }
  
  int first = root->i->first;
  if (i.first < first) {
    root->left = insert(root->left, i);
  } else {
    root->right = insert(root->right, i);
  }
  
  if (root->max < i.last) root->max = i.last;
  return root;  
}

Interval *searchHelper(IntervalNode *root, int x, int &sum) {
  if (root == NULL) return NULL;
  
  if (x >= (root->i)->first && x <= (root->i)->last) {
    sum += (root->i)->weight;    
  }
  
  if (root->left != NULL && root->left->max >= x)
    return searchHelper(root->left, x, sum);
    
  return searchHelper(root->right, x, sum);
}

int search(IntervalNode *root, int x) {
  int weight = 0;
  searchHelper(root, x, weight);
  return weight;
}

void inorder(IntervalNode *root)
{
  if (root == NULL) return;

  inorder(root->left);

  cout << "[" << root->i->first << ", " << root->i->last << "]"
       << " max = " << root->max << endl;

  inorder(root->right);
}

int n, q, i, t, x1, x2, y1, y2;

int main() {
	scanf("%d %d", &n, &q);
  
  IntervalNode *root = NULL;

	for (t = 0; t < n; t++) {
		scanf("%d %d %d %d\n", &x1, &y1, &x2, &y2);
    
    Interval i;
    i.first = x1;
    i.last = --x2;
    i.weight = y2-y1;
    
    root = insert(root, i);    
	}

	while (q--) {
    scanf("%d", &t);
    printf("%d\n", search(root, t)); 
	} 

	return 0;
}	